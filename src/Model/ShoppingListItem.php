<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShoppingListItem extends Model
{
    public $table = "shopping_list_items";

    public $fillable = ['name', 'quantity', 'checked'];

    public static function seedData(int $count): void
    {
        foreach (range(1, $count) as $index) {
            try {
                $item = new ShoppingListItem();
                $item->name = "Item #$index";
                $item->quantity = 1;
                $item->checked = false;
                $item->save();
            } catch (\Throwable $exception) {
                var_dump($exception->getMessage());
                exit;
            }
        }
    }
}