<?php
/**
 * Created by PhpStorm.
 * User: Ahmad Gomaa
 * Date: 6/17/2019
 * Time: 12:05 PM
 */
namespace App\Traits;
trait  ApiResponse
{

    /** return when endpoint success with data and success message
     * @param $data
     * @param $message
     * @param bool $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data, $message, $status = true)
    {
        return response()->json([
                'status' => $status,
                'data' => $data,
                'message' => $message
            ]
        );
    }

    /** return when endpoint fails with error message or validation
     * @param $error
     * @param null $message
     * @param bool $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function failResponse($error, $message = null , $status = false)
    {
        return response()->json([
                'status' => $status,
                'error' => $error,
                'message' => $message
            ]
        );
    }

}