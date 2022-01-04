<?php

namespace App\Http\Controllers\Sync;

use App\Models\Agency;
use App\Models\Course;
use App\Models\School;
use App\Models\SchoolCampus;
use App\Models\Dropdown;
use App\Models\LocationRegion;
use App\Models\LocationProvince;
use App\Models\LocationMunicipality;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SyncController extends Controller
{
    public function locations(){
        $arrays = ['regions','provinces','municipalities'];
        set_time_limit(0);

        foreach($arrays as $array){
            try{
                $url = 'http://isko-main.local/api/01101011%2001110010%2001100001%2001100100/locations/'.$array;
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                ));

                $response = curl_exec($curl);
                curl_close($curl);
            //    $datas = response()->json(json_decode($response));
                $datas = json_decode($response);
                foreach($datas as $data){
                    switch($array){
                        case 'regions':
                            $q = LocationRegion::insertOrIgnore((array)$data); 
                        break;
                        case 'provinces':
                            $q = LocationProvince::insertOrIgnore((array)$data); 
                        break;
                        case 'municipalities':
                            $q = LocationMunicipality::insertOrIgnore((array)$data); 
                        break;
                    }
                    
                }
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }
    }

    public function lists(){
        $arrays = ['agencies','dropdowns','courses','schools'];
        set_time_limit(0);

        foreach($arrays as $array){
            try{
                $url = 'http://isko-main.local/api/01101011%2001110010%2001100001%2001100100/'.$array;
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                ));

                $response = curl_exec($curl);
                curl_close($curl);
            //    $datas = response()->json(json_decode($response));
                $datas = json_decode($response);
                foreach($datas as $data){
                    switch($array){
                        case 'agencies':
                            $q = Agency::insertOrIgnore((array)$data); 
                        break;
                        case 'dropdowns':
                            $q = Dropdown::insertOrIgnore((array)$data); 
                        break;
                        case 'courses':
                            $q = Course::insertOrIgnore((array)$data); 
                        break;
                        case 'schools':
                        // return $data;
                            $arr = (array)$data;
                            $campuses = array_splice($arr,10);
                            $q = School::insertOrIgnore($arr);
                            foreach($data->campuses as $campus)
                            {   
                                $q = SchoolCampus::insertOrIgnore((array)$campus);
                            } 
                        break;
                    }
                    
                }
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }
       
    }
}
