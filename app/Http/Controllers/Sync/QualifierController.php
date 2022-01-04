<?php

namespace App\Http\Controllers\Sync;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Qualifier;
use App\Models\Profile;
use App\Models\Dropdown;

class QualifierController extends Controller
{
    public function fetch(){
        set_time_limit(0);
        try{
            $appids = ['rhxWke3J','Cy8mQqsS','gJN4LTLZ','WqI2GCbL','jG6RVO3F','I8kN8gh6','veFFpDK3','4kX8sPNl','TMQTKDjs','xO9yJDPw','ytPUNTz7','zPEWxgVa'];
            $arr = [];

            foreach($appids as $appid){
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://dashboard.science-scholarships.ph/sch_api/sch_admin/jlss-control-pg.php?appDetails',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('appid' => $appid),
                ));

                $response = curl_exec($curl);
                curl_close($curl);
                $data = json_decode($response);
                // return response()->json(json_decode($response));
                array_push($arr,$data);
            }
            return response()->json($arr);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function store(Request $request){
        set_time_limit(0);
        $result = \DB::transaction(function () use ($request){

            $qualifiers = $request->users;
            $users = array();
            $success = array();
            $failed = array();
            $duplicate = array();

            foreach($qualifiers as $qualifier){
                $count = Qualifier::where('applicant_id',$qualifier['details']['applicant_id'])->count();
                if($count == 0){

                    $dropdown_id = Dropdown::where('name',$qualifier['details']['applied_program'])->pluck('id')->first();
                    
                    $address = [
                        'barangay' => $qualifier['details']['barangay'],
                        'municipality' =>$qualifier['details']['municipality'],
                        'province' => $qualifier['details']['province'],
                    ];

                    $information = [
                        'birth_place' => $qualifier['details']['birth_place'],
                        'course' => $qualifier['details']['course_fullname'],
                        'school' => $qualifier['details']['school_name'],
                        'address' => $address,
                    ];
                    
                    $user = [ 
                        'email' => $qualifier['details']['email'],
                        'firstname' => $qualifier['details']['fname'],
                        'middlename' => $qualifier['details']['mname'],
                        'lastname' => $qualifier['details']['lname'],
                        'suffix' => $qualifier['details']['sname'],
                        'gender' => $qualifier['details']['sex'],
                        'birthday' =>$qualifier['details']['birthday'],
                        'mobile' => ($qualifier['details']['mobile_no'] == '') ? '09123456789' : $qualifier['details']['mobile_no'] ,
                        'information' => json_encode($information),
                        'created_at'	=> now(),
                        'updated_at'	=> now()
                    ];
                    \DB::beginTransaction();
                    $profile = Profile::create($user);

                    if($profile){
                        array_push($success,$qualifier['details']['applicant_id']);
                       
                        $haha = [
                            'lrn' => ($qualifier['details']['deped_lrn'] == '') ? NULL : $qualifier['details']['deped_lrn'],
                            'applicant_id' => $qualifier['details']['applicant_id'],
                            'school_code' => $qualifier['details']['schcode'],
                            'course_id' => $qualifier['details']['crs_id'],
                            'category_id' => $dropdown_id,
                            'profile_id' => $profile->id,
                            'year' =>  date('Y'),
                            'created_at'	=> now(),
                            'updated_at'	=> now()
                        ];
                        
                        $q = Qualifier::insertOrIgnore($haha); 
                        if($q){
                            array_push($success,$qualifier['details']['applicant_id']);
                            \DB::commit();
                        }else{
                            array_push($failed,$qualifier['details']['applicant_id']);
                            \DB::rollback();
                        }

                    }else{
                        array_push($failed,$qualifier['details']['applicant_id']);
                        \DB::rollback();
                    }
                }else{
                    array_push($duplicate,$qualifier['details']['applicant_id']);
                }
            }

            $result = [
                'success' => $success,
                'failed' => $failed,
                'duplicate' => $duplicate,
            ];

            return $result;
            // // dd($users);
            // $collection = collect($users); 
            // $chunks = $collection->chunk(50); 

            // foreach($chunks as $chunk)
            // {
            //     $profile = Profile::insert($chunk->toArray()); 
            // }

        });

        return $result;
    }
}
