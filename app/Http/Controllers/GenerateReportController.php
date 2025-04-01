<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\ResponseModel;
use App\Models\RespondentModel;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use TCPDF;

class GenerateReportController extends Controller
{
    public function view_generate_report($year) {
        try {
            $responses = $this->get_response($year); // get responses
            // return view
            return view('auth.generate-report', [
                'responses' => $responses,
                'year' => $year
            ]);
        } catch (\Throwable $th) {
            Log::error("Error : ".$th->getMessage());
            abort(500);
        }
    }

    // GET RESPONSES
    private function get_response($year) {
        try {
            // GET RESPONSES
            $responses = ResponseModel::select('*')
                ->whereYear('date_time', $year)
                ->get()
                ->sortBy('date_time')
                ->map(function($query){ // MAP DATA FOR GETTING THE FULLNAME OF THE RESPONDERS
                    $query->encrypted_id = Crypt::encrypt($query->id);
                    if(strlen($query->respondent_id) > 1){

                        // MAKE THE RESPONDER ID INTO ARRAY
                        $array_ids = explode(",", $query->respondent_id);

                        // MAKE A BASE STRING FOR THE RESPONDERS NAME TO CONCAT
                        $query->respondents_name = "";

                        // GET ARRAY COUNT OF THE RESPONDERS
                        $count = count($array_ids);

                        // ITERATION BASE COUNT
                        $iteration_count = 1;

                        $loop_iteration = 0;

                        foreach($array_ids as $id){

                            // IF THE RESPONDERS COUNT EQUALS TO NUMBER OF LOOP ITERATION THEN REMOVE THE ", " STRING
                            if($count == $iteration_count){
                                $responder = RespondentModel::fullName($id)->first();
                                // dd($responder);
                                $query->respondents_name .= $responder->full_name;

                            }else{ // ELSE PUT STRING ", "
                                // dd($responder);
                                $responder = RespondentModel::fullName($id)->first();
                                // dd($responder[0]);
                                $query->respondents_name .=$responder->full_name . ", ";
                            }

                            // ADD 1 INTO EACH LOOP
                            $iteration_count++;
                            $loop_iteration++;
                        };

                    }else{ // JUST GET THE NAME OF THE RESPONDER
                        $responder = RespondentModel::fullName($query->respondent_id)->first();
                        // dd($responder);
                        $query->respondents_name .= $responder->full_name;

                    }

                    // RETURN QUERY
                    return $query;
                });

            // RETURN RESPONSE
            return $responses;
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    // generate pdf report
    public function generate_pdf_report($year) {
        try {
            $responses = $this->get_response($year);

            $pdf = Pdf::loadview('auth.pdfs.yearly-report', [
                'responses' => $responses,
                'year' => $year
            ]);

            $pdf->setPaper('legal', 'landscape')->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);

            return $pdf->stream('incident_report.pdf');
        } catch (\Throwable $th) {
            Log::error("Error : ".$th->getMessage());
            abort(500);
        }
    }
}
