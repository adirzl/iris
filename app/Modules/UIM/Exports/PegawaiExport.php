<?php

namespace Modules\UIM\Exports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class PegawaiExport implements FromQuery, ShouldAutoSize, ShouldQueue, WithEvents, WithHeadings
{
    use Exportable;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $_request;

    /**
     * ExportLaporanPerjanjian constructor.
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(\Illuminate\Http\Request $request)
    {
        $this->_request = $request;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $query = DB::table('uim_pegawai')
            ->select([
                DB::raw('row_number() over(order by nama, userid)'),
                'userid', 'nama', 'nip', 'email', 'hp', 
                // DB::raw("(select x.nama_cabang from uim_unit_kerja x where x.kode_cabang = uim_pegawai.kode_induk) as nama_induk"), 
                DB::raw("(select x.nama_cabang from uim_unit_kerja x where x.kode_cabang = uim_pegawai.kode_cabang) as nama_cabang"),
                'nama_jabatan', 'nama_penempatan', 'nama_grade', 
                'admin_spv_ti', 'hakakses', 'status_karyawan', 
            ])
            ->orderBy('nama')
            ->orderBy('userid');

        if ($this->_request->nama) {
            $query->where('nama', $this->_request->nama);
        }

        if ($this->_request->unit_kerja) {
            $query->where('kode_cabang', $this->_request->unit_kerja);
        }

        if ($this->_request->status) {
            $query->where('status_karyawan', $this->_request->status);
        }

        return $query;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            // 'User ID', 'Nama', 'NIP', 'Email', 'HP', 'Induk', 'Cabang', 'Jabatan', 'Penempatan', 'Grade', 
            'User ID', 'Nama', 'NIP', 'Email', 'HP', 'Unit Kerja', 'Jabatan', 'Penempatan', 'Grade', 
            'Admin SPV TI', 'Hak Akses', 'Status',
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $arrStyle = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '00000000']
                        ]
                    ],
                ];

                $sheet = $event->getSheet()->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestCol = $sheet->getHighestColumn();

                $sheet->getStyle('A1:' . $highestCol . '1')->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1:' . $highestCol . $highestRow)->getAlignment()
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $sheet->getStyle('A1:' . $highestCol . $highestRow)
                    ->applyFromArray($arrStyle);

                $sheet->getStyle('A1:' . $highestCol . '1')->getFont()->setBold(true);

                $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            }
        ];
    }
}
