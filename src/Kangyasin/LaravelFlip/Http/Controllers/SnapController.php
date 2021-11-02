<?php
namespace Kangyasin\LaravelFlip\Http\Controllers;
use Kangyasin\LaravelFlip\Flip\Flip;
use Auth;
use Kangyasin\LaravelFlip\Exceptions\FlipException;
use Kangyasin\LaravelFlip\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class SnapController extends Controller
{
    public function __construct()
    {
        //set is production to true for production mode

        Flip::$isProduction = config('flip.production');
        Flip::$serverKey = config('flip.key');
        if(Flip::$isProduction){
            Flip::$serverKey = config('flip.key_prod');
        }
    }

    public function bank_inquiry(Request $request)
    {
        $flip = new Flip;
        $bank_inquiry = 'bank_code='.$request->get('bank_code').'&account_number='.$request->get('account_number');
        $result_bank_inquiry = $flip->postSnapBankInquiry($bank_inquiry);
        return ResponseHelper::json($result_bank_inquiry, 200);
    }

    public function bank_disbursement(Request $request)
    {
        try {

            $flip = new Flip;
            $disbursement_inquiry = 'bank_code='.$request->get('bank_code')
            .'&account_number='.$request->get('account_number')
            .'&amount='.$request->get('amount')
            .'&remark='.$request->get('remark')
            .'&beneficiary_email='.$request->get('beneficiary_email')
            .'&recipient_city='.$request->get('recipient_city');
            $result_disbursement_inquiry = $flip->postSnapDisbursementInquiry($disbursement_inquiry, rand(5,1000));

            return ResponseHelper::json($result_disbursement_inquiry, 200);

        } catch (\Exception $e) {
            throw new FlipException($e->getMessage(), 500, $e, Auth::user(), 'Flip Disbursement Failed');
        }
    }

    public function balance(Request $request)
    {
        $flip = new Flip;
        $result_bank_inquiry = $flip->getSnapBalance();
        return ResponseHelper::json($result_bank_inquiry, 200);
    }

    public function disbursement(Request $request, $flip_id = '')
    {
        $filter_disbursement = '';
        if($flip_id === '')
        {
            $filter_disbursement = http_build_query($request->all());
        }
        $flip = new Flip;
        $result_disbursement_inquiry = $flip->getDisbursement($filter_disbursement, $flip_id);
        return ResponseHelper::json($result_disbursement_inquiry, 200);
    }

    public function special_disbursement_id(Request $request, $flip_id = '')
    {
        $flip = new Flip;
        $result_bank_inquiry = $flip->getSpecialByIdDisbursement($request, $flip_id);
        return ResponseHelper::json($result_bank_inquiry, 200);
    }

    public function special_disbursement_id_empotency(Request $request, $id_empotency = '')
    {
        $request['empotency_id'] = $id_empotency;
        $flip = new Flip;
        $result_bank_inquiry = $flip->getSpecialByIdEmpotencyDisbursement($request, $id_empotency);

        return ResponseHelper::json($result_bank_inquiry, 200);
    }

    public function city_list(Request $request)
    {

        $flip = new Flip;
        $city_list = $flip->getCityList($request);

        return ResponseHelper::json($city_list, 200);
    }

    public function country_list(Request $request)
    {

        $flip = new Flip;
        $country_list = $flip->getCountryList($request);

        return ResponseHelper::json($country_list, 200);
    }

    public function city_country_list(Request $request)
    {
        $flip = new Flip;
        $country_city_list = $flip->getCityCountryList($request);

        return ResponseHelper::json($country_city_list, 200);
    }
}
