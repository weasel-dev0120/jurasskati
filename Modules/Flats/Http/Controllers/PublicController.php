<?php

namespace TypiCMS\Modules\Flats\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Flats\Models\Flat;
use Mpdf\Mpdf;

class PublicController extends BasePublicController
{
    public function index(): View
    {
        $models = Flat::published()->order()->with('image')->get();

        return view('flats::public.index')
            ->with(compact('models'));
    }

    public function show($slug): View
    {
        $model = Flat::published()->whereSlugIs($slug)->firstOrFail();

        return view('flats::public.show')
            ->with(compact('model'));
    }

    public function download($id)
    {
        $model = Flat::findOrFail($id);

        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $mpdf = new Mpdf([
            'fontDir' => array_merge($fontDirs, [
                resource_path('fonts'),
            ]),
            'fontdata' => $fontData + [ // lowercase letters only in font key
                'montserrat' => [
                    'R' => 'montserrat-v25-latin-ext_latin_cyrillic-regular.ttf',
                ]
            ],
            'default_font' => 'montserrat',
            'mode' => 'utf-8', 
            'format' => 'A4-L',
            'margin_top' => 10,
            'maragin_bottom' => 10,
            'margin_left' => 10,
            'margin_right' => 10,
        ]);

        // Determine total number of floors and collect floor images
        $floorImages = [];
        
        // For lofts, find all related floors with the same floor_location
        if ($model->type == 'loft') {
            // Find the main loft record (usually on floor 1)
            $mainLoft = $model;
            if ($model->floor != 1) {
                // If this is not floor 1, find the floor 1 record
                $mainLoft = Flat::where('type', 'loft')
                    ->where('floor', 1)
                    ->where('floor_location', $model->floor_location)
                    ->first();
                if (!$mainLoft) {
                    $mainLoft = $model; // Fallback to current model
                }
            }
            
            // Add floor 1 image
            if ($mainLoft->image && $mainLoft->image->path) {
                $floorImages[] = $mainLoft->image->path;
            }
            
            // Add floor 2 image if exists
            if ($mainLoft->has_second_floor && $mainLoft->second_image && $mainLoft->second_image->path) {
                $floorImages[] = $mainLoft->second_image->path;
            }
            
            // Check for floor 3 - look for a flat on building floor 3 with same floor_location
            $thirdFloorFlat = Flat::where('type', 'loft')
                ->where('floor', 3)
                ->where('floor_location', $mainLoft->floor_location)
                ->first();
            if ($thirdFloorFlat && $thirdFloorFlat->image && $thirdFloorFlat->image->path) {
                $floorImages[] = $thirdFloorFlat->image->path;
            }
        } else {
            // For apartments, use existing logic
            $floorImages[] = $model->image->path; // Floor 1
            if ($model->has_second_floor && $model->second_image) {
                $floorImages[] = $model->second_image->path; // Floor 2
            }
        }
        
        $totalFloors = count($floorImages);

        // Add all floors to PDF
        foreach ($floorImages as $index => $imagePath) {
            if ($index > 0) {
                $mpdf->AddPage();
            }
            
            $html = view('flats::public.pdf')
                ->with([
                    'model' => $model,
                    'image' => $imagePath,
                    'level' => $index + 1,
                    'totalFloors' => $totalFloors,
                ])
                ->render();
            $mpdf->WriteHTML($html);
            
            // Set footer with page numbers (only after first page)
            if ($index == 0) {
                $mpdf->SetHTMLFooter('<table width="100%" style="font-size: 9pt;"><tr><td width="33%"></td><td width="33%" align="center">{PAGENO} / {nbpg}</td><td align="right" width="33%">' . $_SERVER['HTTP_HOST'] . '</td></tr></table>');
            }
        }

        $filename = str_replace('/', '-', $model->number);
        $filename = str_replace(' ', '-', $filename);
        $filename = preg_replace('/[^A-Za-z0-9\-\_]/', '', $filename);
        $filename = preg_replace('/-+/', '-', $filename);
        $filename = 'JurasSkati_' . $filename . '_' . config('app.locale') . '.pdf';
        return response()->streamDownload(function() use ($mpdf , $filename) {
            echo $mpdf->Output($filename, 'D');
        }, $filename);
    }
}
