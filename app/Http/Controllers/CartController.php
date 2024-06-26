<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::forCurrentSession()
            ->orderbyDesc('id')->paginate(12);

        $cartTotal = 0;
        if ($cartItems->count() > 0) {
            foreach ($cartItems as $cartItem) {
                $cartTotal += $cartItem->getTotalAmount();
            }
        }

        return theme_view('cart', [
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
        ]);
    }

    public function addItem(Request $request)
    {
        $item = Item::where('id', $request->item_id)
            ->approved()->purchasingEnabled()->first();

        if (!$item) {
            return response()->json([
                'error' => translate('The chosen item are not available'),
            ]);
        }

        $validator = Validator::make($request->all(), [
            'license_type' => ['required', 'integer', 'min:1', 'max:2'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return response()->json(['error' => $error]);
            }
        }

        $user = authUser();

        if ($user) {
            if ($user->id == $item->author_id) {
                return response()->json([
                    'error' => translate('You cannot purchase your own item'),
                ]);
            }
            $sessionId = null;
            $userId = $user->id;

            $cartItem = CartItem::where('user_id', $userId)
                ->where('item_id', $item->id)
                ->where('license_type', $request->license_type)->first();

        } else {
            if (session()->has('session_id')) {
                $sessionId = session()->get('session_id');
            } else {
                $sessionId = sha1(Str::random(12) . time());
                session()->put('session_id', $sessionId);
            }
            $userId = null;

            $cartItem = CartItem::where('session_id', $sessionId)
                ->where('item_id', $item->id)
                ->where('license_type', $request->license_type)
                ->first();
        }

        if (!$cartItem) {
            $cart = new CartItem();
            $cart->session_id = $sessionId;
            $cart->user_id = $userId;
            $cart->item_id = $item->id;
            $cart->license_type = $request->license_type;
            $cart->save();
        } else {
            if ($cartItem->quantity >= 50) {
                return response()->json([
                    'error' => translate('You have reached the limit for each item'),
                ]);
            }
            $cartItem->increment('quantity');
        }

        return response()->json([
            'success' => translate('The item added to cart'),
        ]);
    }

    public function updateItem(Request $request, $id)
    {
        $cartItem = CartItem::where('id', $id)
            ->forCurrentSession()->firstOrFail();

        $validator = Validator::make($request->all(), [
            'license_type' => ['required', 'integer', 'min:1', 'max:2'],
            'quantity' => ['required', 'integer', 'min:1', 'max:50'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $cartItemExists = CartItem::whereNot('id', $cartItem->id)
            ->where('item_id', $cartItem->item_id)
            ->where('license_type', $request->license_type)
            ->forCurrentSession()
            ->first();

        if ($cartItemExists) {
            $cartItemExists->increment('quantity', $request->quantity);
            $cartItem->delete();
        } else {
            $cartItem->license_type = $request->license_type;
            $cartItem->quantity = $request->quantity;
            $cartItem->update();
        }

        toastr()->success(translate('The cart item has been updated'));
        return back();
    }

    public function removeItem(Request $request, $id)
    {
        $cartItem = CartItem::where('id', $id)
            ->forCurrentSession()->firstOrFail();
        $cartItem->delete();
        return back();
    }

    public function empty(Request $request)
    {
        $cartItems = CartItem::forCurrentSession()->get();

        if ($cartItems->count() > 0) {
            foreach ($cartItems as $cartItem) {
                $cartItem->delete();
            }
        }

        return back();
    }

    public function checkout(Request $request)
    {
        $cartItems = CartItem::forCurrentSession()->get();

        if ($cartItems->count() > 0) {
            $transactionTotalAmount = 0;
            foreach ($cartItems as $cartItem) {
                $transactionTotalAmount += $cartItem->getTotalAmount();
            }

            $items = [];
            foreach ($cartItems as $cartItem) {
                $item = $cartItem->item;
                $items[] = [
                    'id' => $item->id,
                    'license_type' => $cartItem->license_type,
                    'price' => $cartItem->isLicenseTypeRegular() ? $item->price->regular : $item->price->extended,
                    'quantity' => $cartItem->quantity,
                    'total' => $cartItem->getTotalAmount(),
                ];
            }

            $transaction = Transaction::prepareForCheckout($transactionTotalAmount, $items);
            return redirect()->route('checkout.index', hash_encode($transaction->id));
        }

        return back();
    }

}
