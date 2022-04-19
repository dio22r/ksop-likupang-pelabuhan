<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\MenuHelper;
use App\Helpers\UserManagementHelper;
use App\Models\UserGroupModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class UserManagementController extends BaseController
{
	use ResponseTrait;

	protected $menuId = 3;

	public function __construct()
	{
		$this->userMngHelper = new UserManagementHelper();
		$this->menuHelper = new MenuHelper();
		$this->userModel = model("UserModel");

		if (!$this->menuHelper->is_menu_authorized($this->menuId)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			return;
		}
	}

	public function view_index()
	{

		$arrView = [
			"page_title" => "User Management",
			"ctl_id" => $this->menuId,

			"arrJs" => [
				base_url("/assets/js/controller-admin/user-management/index.js?new"),
			],

			"arrCss" => []
		];

		return view("/admin_view/user-management/vw_index", $arrView);
	}

	public function view_form($id = "")
	{
		$isNew = true;
		$arrData = false;
		if ($id) {
			$arrData = $this->userModel->find($id);
			if (!$arrData) {
				throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
				return;
			}
			$isNew = false;
			$arrData["password"] = "";
		}

		$userGrpModel = model("UserGroupModel");
		$arrRole = $userGrpModel->findAll();

		$arrView = [
			"page_title" => "User Form",
			"ctl_id" => $this->menuId,

			"arrJs" => [
				base_url("/assets/js/controller-admin/user-management/form.js?new"),
			],

			"arrUserRole" => $arrRole,
			"is_new" => $isNew,
			"jsConfig" => [
				"detail" => $arrData
			]
		];

		return view("/admin_view/user-management/vw_form", $arrView);
	}

	// API
	public function index()
	{
		$page = $this->request->getGet("page");
		$perpage = $this->request->getGet("limit");
		$status = $this->request->getGet("status");

		if (!$perpage) $perpage = 20;
		if (trim($page) == "" || $page < 0) $page = 1;
		if ($status == "") $status = 1;

		$arrData = $this->userMngHelper->retrieve_json_table(
			$page,
			$perpage,
			$this->request->getGet("search"),
			"nama",
			["user.status" => $status, "role <>" => 6]
		);


		$arrRes = [
			"data" => $arrData["data"],
			"total" => $arrData["total"],
			"totalpage" => ceil($arrData["total"] / $perpage)
		];

		return $this->respond($arrRes, 200);
	}

	public function create()
	{
		$arrSave = [
			"nama" => $this->request->getPost("nama"),
			"username" => $this->request->getPost("username"),
			"password" => $this->request->getPost("password"),
			"role" => $this->request->getPost("role"),
			"status" => $this->request->getPost("status"),
		];

		$arrData = $arrErr = [];
		$status = $this->userModel->save($arrSave);
		if (!$status) {
			$arrErr = $this->userModel->errors();
		} else {
			$id = $this->userModel->insertID;
			$arrData = $this->userModel->find($id);
		}

		$arrRes = [
			"status" => $status,
			"arrError" => $arrErr,
			"arrData" => $arrData
		];

		return $this->respond($arrRes, 200);
	}

	public function show($id)
	{
		$arrData = $this->userModel->select("user.*, t1.title as role_name")
			->join("user_group t1", "user.role = t1.id")
			->where("user.id", $id)
			->withDeleted()
			->first();

		$status = false;
		if ($arrData) {
			$status = true;
		}

		$arrRes = [
			"status" => $status,
			"arrData" => $arrData
		];

		return $this->respond($arrRes, 200);
	}

	public function update($id)
	{
		$arrJson = $this->request->getJSON();
		$arrErr = [];
		$status = false;

		if ($arrJson) {
			$arrSave = [
				"id" => $id,
				"nama" => $arrJson->nama,
				"username" => $arrJson->username,
				"role" => $arrJson->role,
				"status" => $arrJson->status,
			];

			$password = $arrJson->password;
			if (trim($password)) {
				$arrSave["password"] = $password;
			} else {
				$arrValidation = $this->userModel->validationRules;
				unset($arrValidation["password"]);
				$this->userModel->setValidationRules($arrValidation);
			}

			$status = $this->userModel->update($id, $arrSave);
			if (!$status) {
				$arrErr = $this->userModel->errors();
			}
		}


		$arrRes = [
			"status" => $status,
			"arrError" => $arrErr,
			"arrData" => $arrJson
		];

		return $this->respond($arrRes, 200);
	}

	public function delete($id)
	{
		$arrData = $this->userModel->find($id);
		$status = false;
		if ($arrData) {
			$arrUpdate = ["status" => 0];
			$status = $this->userModel->update($id, $arrUpdate);
		}

		$arrRes = [
			"status" => $status,
			"arrData" => $arrData
		];

		return $this->respond($arrRes, 200);
	}
}
