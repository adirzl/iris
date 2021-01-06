<?php

namespace Modules\Kuisioner\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Modules\IsiKuisioner\Entities\IsiKuisioner;
use Modules\IsiKuisioner\Entities\IsiKuisionerDetail;
use Modules\Kelola\Entities\Comprof;
use Modules\Kuisioner\Entities\Pertanyaan;

class KuisionerExport implements FromView, ShouldAutoSize, WithEvents
{
    use Exportable;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $id;

    /**
     * ExportLaporanPerjanjian constructor.
     * @param \Illuminate\Http\Request $request
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        $kuisioner = IsiKuisioner::findOrFail($this->id);
        $data_penilaian = IsiKuisionerDetail::where('id_induk', $this->id)->get();
        $nama_perusahaan = Comprof::where('status', 1)->where('id', $kuisioner->nama_perusahaan)->get();
        foreach ($nama_perusahaan as $item);
        $nama_perusahaan = $item->company_name;
        if($kuisioner->status_kuisioner == 1){
            $data_pertanyaan = Pertanyaan::with('detail_pertanyaan')->where('status_user', 1)->where('status', 1)->get();
        } else {
            $data_pertanyaan = Pertanyaan::with('detail_pertanyaan')->where('status_user', 2)->where('status', 1)->get();
        }
        $file_jawaban = 'file';
        $company_name = to_dropdown(Comprof::where('status', 1)->get(), 'id', 'company_name');
        return view('kuisioner::penilaian.xls', compact('kuisioner', 'data_penilaian', 'data_pertanyaan', 'file_jawaban', 'company_name', 'nama_perusahaan'));
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
