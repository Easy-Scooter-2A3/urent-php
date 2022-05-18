<?php

namespace App\Actions\Partnership;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Partnership;


class CreatePartnership
{
    use AsAction;

    public function rules()
    {
        return [
            'name' => ['required'],
            'from_date' => ['required'],
            'to_date' => ['required'],
            'voucher' => ['required'],
            'max_people' => ['required'],
            'active' => ['required'],
        ];
    }

    public function handle($data)
    {
        return Partnership::create([
            ...$data,
            'from_date' => date('Y-m-d H:i:s', strtotime($data['from_date'])),
            'to_date' => date('Y-m-d H:i:s', strtotime($data['to_date']))
        ]);
    }

    public function asController(Request $request)
    {
        $this->handle(
            $request->all()
        );
        return response()->json(['success' => true]);
    }
}
