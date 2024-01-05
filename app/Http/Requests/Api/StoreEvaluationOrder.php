<?php

namespace App\Http\Requests\Api;

use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluationOrder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!$client = auth()->user()) {
            return false;
        }

        if(!$order = app(OrderRepositoryInterface::class)->getOrderByIdentify($this->identify)) {
            return false;
        }

        return $client->id === $order->client_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'stars' => ['required', 'min:1', 'integer', 'max:5'],
            'comment' => ['nullable', 'min:3', 'max:1000']
        ];
    }
}
