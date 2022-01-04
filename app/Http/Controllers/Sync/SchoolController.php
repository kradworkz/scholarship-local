<?php

namespace App\Http\Controllers\Sync;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function fetch(){
        set_time_limit(0);
        try{
            $arr = [];
          
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://dashboard.science-scholarships.ph/sch_api/sch_admin/usas-control-pg.php?getSchools',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('remarks' => ''),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $data = json_decode($response);

            return response()->json($data);

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

            foreach($schools as $school){
                $count = School::where('deped_id',$school['depedid'])->count();
                if($count == 0){

                    $term_id = Dropdown::where('name',$school['sterm'])->pluck('id')->first();
                    $class_id = Dropdown::where('name',$school['sclass'])->pluck('id')->first();
                    
                    $address = [
                        'barangay' => $school['st_brgy'],
                        'municipality' => $school['smuni'],
                        'province' => $school['spro'],
                    ];

                    $information = [
                        'birth_place' => $school['details']['birth_place'],
                        'registrar' => ($school['registrar'] == '') ? 'n/a' : $school['registrar'] ,
                        'principal' => ($school['principal'] == '') ? 'n/a' : ucwords(strtolower($school['principal'])) ,
                        'phone' => $school['phone'],
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
