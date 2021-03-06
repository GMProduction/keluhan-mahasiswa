<?php


namespace App\Helper;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\DataTables;

class CustomController extends Controller
{

    protected $model;

    protected $validationRules = [];

    protected $validationMessage = [];

    /** @var Request $request */
    protected $request;

    /**
     * CustomController constructor.
     */
    public function __construct()
    {
        $this->request = Request::createFromGlobals();
    }


    public function insert($class = null, $data = [])
    {
        $model = new $class();
        foreach ($data as $key => $d) {
            $model[$key] = $data[$key];
        }
        return $model->save() ? $model : false;
    }

    public function update($class = null, $data = [])
    {
        $id = $this->request->request->get('id');
        $model = $class::find($id);
        foreach ($data as $key => $d) {
            $model[$key] = $data[$key];
        }
        return $model->save() ? $model : false;
    }

    public function directInsert($class = null, $data = [])
    {
        $model = new $class();
        foreach ($data as $key => $d) {
            $model[$key] = $data[$key];
        }
        $model->save();
        return $model;
    }

    public function directUpdate($class = null, $id = 1, $data = [])
    {
        $model = $class::find($id);
        foreach ($data as $key => $d) {
            $model[$key] = $data[$key];
        }
        $model->save();
        return $model;
    }

    public function generateImageName($field = '')
    {
        $value = '';
        if ($this->request->hasFile($field)) {
            $files = $this->request->file($field);
            $extension = $files->getClientOriginalExtension();
            $name = $this->uuidGenerator();
            $value = $name . '.' . $extension;
        }
        return $value;
    }

    //disk setting on app/config/filesystem
    public function uploadImage($field, $targetName = '', $disk = 'upload')
    {
        $file = $this->request->file($field);
        return Storage::disk($disk)->put($targetName, File::get($file));
    }

    public function uuidGenerator()
    {
        return Uuid::uuid1()->toString();
    }

    public function checkValidation(Request $request)
    {
        $data = $request->all();
        return Validator::make($data, $this->getValidationRules(), $this->getValidationMessage());
    }

    public function isAuth($credentials = [])
    {
        if (count($credentials) > 0 && Auth::attempt($credentials)) {
            return true;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getValidationRules()
    {
        return $this->validationRules;
    }

    /**
     * @param mixed $validationRules
     * @return CustomController
     */
    public function setValidationRules($validationRules)
    {
        $this->validationRules = $validationRules;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValidationMessage()
    {
        return $this->validationMessage;
    }

    /**
     * @param mixed $validationMessage
     * @return CustomController
     */
    public function setValidationMessage($validationMessage)
    {
        $this->validationMessage = $validationMessage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     * @return CustomController
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    public function postField($key)
    {
        return $this->request->request->get($key);
    }

    public function field($key)
    {
        return $this->request->query->get($key);
    }

    public function jsonResponse($msg = '', $status = 200, $data = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $msg,
            'payload' => $data
        ], $status);
    }

    public function generateTokenById($id, $role)
    {

        return auth('api')->setTTL(null)
            ->claims([
                'role' => $role,
            ])->tokenById($id);
    }

    public function getCity()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 2ffbe3b7365f2ccb2c3929a3a4de486c"
            ),
        ));

        $response = curl_exec($curl);
        return json_decode($response, true);
    }

    public function getOnkgir($tujuan)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=445&destination=" . $tujuan . "&weight=1700&courier=jne",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 2ffbe3b7365f2ccb2c3929a3a4de486c"
            ),
        ));

        $response = curl_exec($curl);
        return json_decode($response, true);
    }

    public function convertToPdf($viewRender, $data = [])
    {
        $html = view($viewRender)->with($data);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        return $pdf->stream();
    }

    public function basicDataTables($object)
    {
        return DataTables::of($object)->addIndexColumn()->make(true);
    }

    public function send_notification(Messaging $messaging, $to, $title = 'Title', $body = 'Body')
    {
        $data['title'] = $title;
        $data['body'] = $body;
        $message = CloudMessage::fromArray([
            'token' => $to,
            'data' => $data,
            'webpush' => [
                'headers' => [
                    'Urgency' => 'normal',
                ],
            ],

        ]);
        $messaging->send($message);
    }

    public function push_notif($title, $body)
    {
        $SERVER_API_KEY = 'AAAABjhw5Jk:APA91bG_d1uDJqYKpKo3VdlpQLUhF7iiN5A6eqb3efSq8mWeX6LatHXBuPhPor4cCBNbvfMvCBVvPMDH09Ahm_KlQenuPA2kPPyZlmwAr9-GBCBLQ9B7_pcNp4eNf6wUpIoS8eH-n0o1';

        $data = [
            "registration_ids" => ['faTrQsjUDqa1vqpAyGlrL1:APA91bEbFd032mw1sX7MqapDv57pah4dhbRwFcE_aGaCflsB__NgGChNtXauhgkjGicYxYbQ7uSGlCC0cEuKF9hNBxr3kchh2hCyGK9lPSVLls_Nvxfi3IffBBmNysuX6Vvf2Xqm-j54'],
            "notification" => [
                "title" => $title,
                "body" => $body,
            ]
        ];

        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
        return $response;
    }
}
