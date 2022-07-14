<?php

namespace App\Actions\Partnership;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Partnership;
use App\Models\partnership_product;

class EditPartnership
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

    public function handle($data, $id)
    {
        $productsIds = $data['products'];

        unset($data['products']);
        Partnership::where('id', $id)
            ->update([
                ...$data,
                'from_date' => date('Y-m-d H:i:s', strtotime($data['from_date'])),
                'to_date' => date('Y-m-d H:i:s', strtotime($data['to_date']))
            ]);

        partnership_product::where('partnership_id', $id)->delete();

        foreach ($productsIds as $key => $productid) {
            partnership_product::create([
                'partnership_id' => $id,
                'product_id' => $productid,
            ]);
        }
    }

    public function asController(Request $request, int $id)
    {
        $this->handle(
            $request->all(),
            $id
        );
        return response()->json(['success' => true]);
    }
}
