<?php

namespace Gui\Mvc\Controllers\Admin;

use Gui\Mvc\Core\Controller;
use Gui\Mvc\Enums\AdminStatusEnum;
use Gui\Mvc\Enums\HttpStatusEnum;
use Gui\Mvc\Helpers\Hash;
use Gui\Mvc\Helpers\Session;
use Gui\Mvc\Helpers\Validator;
use Gui\Mvc\Models\AdminModel;

class AdminController extends Controller
{
    public AdminModel $adminModel;

    public function __construct()
    {
        parent::__construct();
        $this->adminModel = new AdminModel();
    }

    public function Index()
    {
        echo "oi";
    }

    public function viewLogin(): bool
    {
        return $this->view->render('admin/login');
    }

    /**
     * Handle admin user authentication
     */
    public function auth()
    {
        $payload = [
            'username' => $this->request()->post('username'),
            'password' => $this->request()->post('password')
        ];

        $validator = (new Validator())->make($payload, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if (!empty($validator->errors())) {
            return $this->response()->json(['status' => '1', 'errors' => $validator->errors()]);
        }

        $user = $this->adminModel
            ->first()
            ->find('username=:username', 'username=' . $payload['username'], 'id,username,password,status')
            ->fetch();


        if (!$user) {
            return $this->response()
                ->status(HttpStatusEnum::UNAUTHORIZED)
                ->json(['status' => '1', 'msg' => 'Username not found']);
        }

        $validateUserStatus = $this->validateAdminStatus($user['status']);

        if (!(new Hash)->check($payload['password'], $user['password'])) {
            return $this->response()
                ->status(HttpStatusEnum::UNAUTHORIZED)
                ->json(['status' => '1', 'msg' => 'Invalid Password']);
        }

        if (isset($validateUserStatus['error'])) {
            return $this->response()
                ->status(HttpStatusEnum::UNAUTHORIZED)
                ->json(['status' => '1', 'msg' => $validateUserStatus['error']]);
        }

        Session::set('admin_auth_user_id', (int)$user['id']);

        return $this->response()->json(['status' => '1', 'msg' => 'Successfully Authenticated', 'redirect' => 'dashboard']);
    }

    private function validateAdminStatus(string $status)
    {

        switch ($status) {
            case AdminStatusEnum::ADMIN_STATUS_PENDENT:
                return ['error' => 'Your account is currently pending.'];
                break;
            case AdminStatusEnum::ADMIN_STATUS_BANNED:
                return ['error' => 'Your account is currently banned.'];
                break;
            default:
                return true;
                break;
        }

    }

}