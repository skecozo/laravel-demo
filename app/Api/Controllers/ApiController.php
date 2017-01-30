<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-17
 * Time: 5:37
 */

namespace App\Api\Controllers;




use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ApiController extends BaseController
{
    protected $statusCode = 200;

    public function getStatusCode()
    {
        return $this->statusCode;
    }


    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function respondWithValidatorError($message)
    {
        return \Response::json([
            'status'=>'success',
            'status_code'=>422,
            'message'=>$message
        ]);
    }

    public function noContent()
    {
        return response()->json(null, 204);
    }

    /**
     * @param $message
     * @param $errorCode
     * @return mixed
     */
    public function respondWithError($message, $errorCode)
    {
        return \Response::json([
            'error'=>$message,
             'status_code'=>$errorCode,
        ]);
    }
    /**
     * @param array $array
     * @param array $headers
     * @return mixed
     */
    protected function respondWithArray(array $array, array $headers = [])
    {
        $response = \Response::json($array, $this->statusCode, $headers);

        return $response;
    }



    public function respondWith($data, $callback, $includes=[]){
        //if $data is null throw error
        if(!$data){
            return $this->errorNotFound('Requested response not found.');
        }
        //if $data is a Collection or a Paginated Collection
        else if($data instanceof Collection || $data instanceof LengthAwarePaginator){
            return $this->respondWithCollection($data, $callback, $includes);
        }
        //if $data is an Item
        else if($data instanceof Model){
            return $this->respondWithItem($data, $callback, $includes);
        }
        else {
            return $this->errorInternalError();
        }
    }

    /**
     * @param $item
     * @param $callback
     * @param array $includes
     * @return mixed
     */
    protected function respondWithItem($item, $callback, $includes=[])
    {
        return Fractal::includes($includes)->item($item, $callback)->responseJson();
    }

    /**
     * @param $collection
     * @param $callback
     * @param array $includes
     * @return mixed
     */
    protected function respondWithCollection($collection, $callback, $includes=[])
    {
        return Fractal::includes($includes)->collection($collection, $callback)->responseJson();

    }


    /**
     * Generates a Response with a 500 HTTP header and a given message.
     *
     * @param string $message
     * @return Response
     */
    public function errorInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(500)
            ->respondWithError($message, self::CODE_INTERNAL_ERROR);
    }

    /**
     * Generates a Response with a 404 HTTP header and a given message.
     *
     * @param string $message
     * @return Response
     */
    public function errorNotFound($message = 'Resource Not Found')
    {
        return $this->setStatusCode(404)
            ->respondWithError($message, self::CODE_NOT_FOUND);
    }
}