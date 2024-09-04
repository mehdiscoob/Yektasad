<?php

namespace App\Http\Controllers;


use App\Http\Requests\Order\CreateOrderRequest;
use App\Services\order\OrderService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\Info(
 *      title="Your API Title",
 *      version="1.0.0",
 *      description="Your API description",
 *      @OA\Contact(
 *          email="contact@example.com"
 *      ),
 *      @OA\License(
 *          name="MIT License",
 *          url="https://opensource.org/licenses/MIT"
 *      )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


}
