<?php

namespace Modules\HCS\Exports;

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
        $query = DB::table('hcs_pegawai')
            ->select([
                DB::raw('row_number() over(order by hcs_pegawai.nama, userid)'),
                'userid', 'hcs_pegawai.nama', 'nip', 'email', 'hp', 
                DB::raw("(select x.nama from hcs_unit_kerja x where x.kode = hcs_pegawai.kode_unit_kerja) as unit_kerja"), 
                DB::raw("(select x.nama from hcs_unit_kerja x where x.kode = hcs_pegawai.kode_penempatan) as penempatan"), 
                DB::raw("(case when hcs_pegawai.kode_jabatan is not null then hcs_jabatan.nama else '-' end) as jabatan"), 
                DB::raw("(case when hcs_pegawai.kode_grade is not null then hcs_grade.nama else '-' end) as grade"), 'status_karyawan',
            ])
            ->leftJoin('hcs_grade', 'hcs_pegawai.kode_grade', '=', 'hcs_grade.kode')
            ->leftJoin('hcs_jabatan', 'hcs_pegawai.kode_jabatan', '=', 'hcs_jabatan.kode')
            ->orderBy('hcs_pegawai.nama')
            ->orderBy('userid');

        if ($this->_request->nama) {
            $query->where('hcs_pegawai.nama', $this->_request->nama);
        }

        if ($this->_request->unit_kerja) {
            $query->where('hcs_pegawai.kode_unit_kerja', $this->_request->unit_kerja);
        }

        if ($this->_request->status) {
            $query->where('hcs_pegawai.status', $this->_request->status);
        }

        return $query;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No.', 'User ID', 'Nama', 'NIP', 'Email', 'HP', 'Unit Kerja', 'Penempatan', 'Jabatan', 'Grade', 'Status',
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
