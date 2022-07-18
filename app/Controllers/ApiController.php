<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Controller;

use App\Models\EmployeeModel;
class ApiController extends ResourceController
{
	public function addEmployee()
	{
		$rules = [
			"name" => "required",
			"email" => "required|valid_email|is_unique[employees.email]|min_length[6]",
			"phone_no" => "required",
		];

		$messages = [
			"name" => [
				"required" => "Name is required"
			],
			"email" => [
				"required" => "Email required",
				"valid_email" => "Email address is not in format",
				"is_unique" => "Email address already exists"
			],
			"phone_no" => [
				"required" => "Phone Number is required"
			],
		];

		if (!$this->validate($rules, $messages)) {

			$response = [
				'status' => 500,
				'error' => true,
				'message' => $this->validator->getErrors(),
				'data' => []
			];
		} else {

			$emp = new EmployeeModel();

			$data['name'] = $this->request->getVar("name");
			$data['email'] = $this->request->getVar("email");
			$data['phone_no'] = $this->request->getVar("phone_no");

			$emp->save($data);

			$response = [
				'status' => 200,
				'error' => false,
				'message' => 'Employee added successfully',
				'data' => []
			];
		}

		return $this->respondCreated($response);
	}

	public function listEmployee()
	{
		$emp = new EmployeeModel();

		$response = [
			'status' => 200,
			"error" => false,
			'messages' => 'Employee list',
			'data' => $emp->findAll()
		];

		return $this->respondCreated($response);
	}

	public function singleEmployee($emp_id)
	{
		$emp = new EmployeeModel();

		$data = $emp->find($emp_id);

		if (!empty($data)) {

			$response = [
				'status' => 200,
				"error" => false,
				'messages' => 'Single employee data',
				'data' => $data
			];

		} else {

			$response = [
				'status' => 500,
				"error" => true,
				'messages' => 'No employee found',
				'data' => []
			];
		}

		return $this->respondCreated($response);
	}

	public function updateEmployee($emp_id)
	{
		$rules = [
			"name" => "required",
			"email" => "required|valid_email|min_length[6]",
			"phone_no" => "required",
		];

		$messages = [
			"name" => [
				"required" => "Name is required"
			],
			"email" => [
				"required" => "Email required",
				"valid_email" => "Email address is not in format"
			],
			"phone_no" => [
				"required" => "Phone Number is required"
			],
		];

		if (!$this->validate($rules, $messages)) {

			$response = [
				'status' => 500,
				'error' => true,
				'message' => $this->validator->getErrors(),
				'data' => []
			];
		} else {

			$emp = new EmployeeModel();

			if ($emp->find($emp_id)) {

				$data['name'] = $this->request->getVar("name");
				$data['email'] = $this->request->getVar("email");
				$data['phone_no'] = $this->request->getVar("phone_no");

				$emp->update($emp_id, $data);

				$response = [
					'status' => 200,
					'error' => false,
					'message' => 'Employee updated successfully',
					'data' => []
				];
			}else {

				$response = [
					'status' => 500,
					"error" => true,
					'messages' => 'No employee found',
					'data' => []
				];
			}
		}

		return $this->respondCreated($response);
	}

	public function deleteEmployee($emp_id)
	{
		$emp = new EmployeeModel();

		$data = $emp->find($emp_id);

		if (!empty($data)) {

			$emp->delete($emp_id);

			$response = [
				'status' => 200,
				"error" => false,
				'messages' => 'Employee deleted successfully',
				'data' => []
			];

		} else {

			$response = [
				'status' => 500,
				"error" => true,
				'messages' => 'No employee found',
				'data' => []
			];
		}

		return $this->respondCreated($response);
	}
}