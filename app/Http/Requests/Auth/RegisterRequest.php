<?php
namespace App\Http\Requests\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:150'],
            'email'    => ['required', 'email', 'string', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8','max:255', 'confirmed']
        ];
    }
    public function getSanitizedData(): array
    {
        $data= $this->validated();
        $data['password'] = Hash::make($data['password']);
        return $data;
    }
}
