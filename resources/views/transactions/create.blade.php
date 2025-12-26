<x-app-layout>
    @php
        $productMap = [];
        foreach ($products as $product) {
            $productMap[$product->id] = [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => $product->price,
                'img'   => $product->image,
                'category_id' => $product->category_id,
            ];
        }
    @endphp

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">
                <i class="mr-2 fas fa-cash-register"></i> Transaksi Baru
            </h2>
            <span class="text-sm text-gray-600">
                <i class="mr-1 fas fa-user"></i> {{ auth()->user()->name }}
            </span>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container max-w-full px-4 mx-auto">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3 lg:grid-cols-4">

                {{-- Produk List --}}
                <div class="md:col-span-2 lg:col-span-3">
                    <div class="p-6 bg-white shadow-md rounded-xl">

                        {{-- Header --}}
                        <div class="flex flex-col gap-4 mb-4 sm:flex-row sm:items-center sm:justify-between">
                            <h3 class="text-lg font-semibold">Daftar Produk</h3>

                            <form method="GET" class="w-full sm:w-64">
                                <input
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Cari produk..."
                                    class="w-full px-4 py-2 border rounded-lg"
                                >
                            </form>
                        </div>

                        {{-- FILTER KATEGORI --}}
                        <div class="flex flex-wrap gap-2 mb-6">
                            <a href="{{ route('transactions.create') }}"
                            class="px-4 py-1.5 rounded-full {{ !request('category') ? 'bg-blue-600 text-white' : 'bg-gray-100' }}">
                                Semua
                            </a>

                            @foreach ($categories as $category)
                                <a href="{{ route('transactions.create', array_merge(request()->query(), ['category' => $category->id])) }}"
                                class="px-4 py-1.5 rounded-full {{ request('category') == $category->id ? 'bg-blue-600 text-white' : 'bg-gray-100' }}">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>

                        {{-- Grid Produk --}}
                        <div id="productGrid" class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                            @foreach ($products as $product)
                                <div class="border rounded-lg shadow-sm product-card hover:shadow-md"
                                     data-id="{{ $product->id }}"
                                     data-name="{{ $product->name }}"
                                     data-category="{{ $product->category_id }}">
                                    <img src="{{ asset('storage/' .$product->image) }}" class="object-cover w-full rounded-t-lg h-28 sm:h-32" alt="{{ $product->name }}">
                                    <div class="p-4">
                                        <h4 class="font-semibold text-gray-800 truncate">{{ $product->name }}</h4>
                                        <div class="flex items-center justify-between mt-3">
                                            <span class="font-bold text-blue-600">Rp{{ number_format($product->price) }}</span>
                                            <button type="button" class="p-2 text-white bg-blue-600 rounded-full add-to-cart-btn hover:bg-blue-700" data-id="{{ $product->id }}">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $products->withQueryString()->links() }}
                        </div>
                    </div>
                </div>

                {{-- Keranjang --}}
                <div class="md:col-span-1">
                    <div class="sticky top-6">
                        <div class="p-6 bg-white shadow-md rounded-xl">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-semibold text-gray-800"><i class="mr-2 fas fa-shopping-cart"></i> Keranjang</h3>
                                <span id="itemCount" class="px-3 py-1 text-sm text-blue-800 bg-blue-100 rounded-full">0 item</span>
                            </div>

                            <div id="emptyCart" class="py-10 text-center text-gray-500">Keranjang masih kosong</div>
                            <div id="cartItems" class="hidden space-y-3"></div>

                            <div id="orderSummary" class="hidden mt-4">
                                <div class="pt-4 space-y-2 border-t">
                                    <div class="flex justify-between text-sm">
                                        <span>Subtotal</span>
                                        <span>Rp<span id="subTotal">0</span></span>
                                    </div>
                                    <div class="flex justify-between text-lg font-semibold">
                                        <span>Total</span>
                                        <span class="text-blue-600">Rp<span id="grandTotal">0</span></span>
                                    </div>
                                </div>

                                <form id="transactionForm" method="POST" action="{{ route('transactions.store') }}" class="mt-4 space-y-4">
                                    @csrf
                                    <input type="hidden" name="cart" id="cartInput">

                                    <div class="space-y-2">
                                        <label class="font-semibold text-gray-700">Metode Pembayaran</label>

                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="payment_method" value="cash" checked>
                                            Cash
                                        </label>

                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="payment_method" value="qris">
                                            QRIS
                                        </label>
                                    </div>

                                    <button type="button" id="submitBtn"
                                        class="w-full py-3 font-bold text-white bg-green-600 rounded-lg hover:bg-green-700">
                                        <i class="mr-2 fas fa-shopping-cart"></i>Transaksi
                                    </button>
                                    <button type="button" id="clearCartBtn" class="w-full py-3 bg-gray-100 rounded-lg hover:bg-gray-200">
                                        <i class="mr-2 fas fa-trash"></i>Kosongkan Keranjang
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    {{-- MODAL QRIS --}}
    <div id="qrisModal"
        class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/60">

        <div class="w-full max-w-lg p-8 space-y-6 bg-white shadow-xl rounded-2xl">

            <h3 class="text-xl font-semibold text-center">Scan QRIS</h3>

            <p class="text-lg font-semibold text-center text-blue-600">
                Total Bayar: Rp<span id="qrisTotal">0</span>
            </p>
            
            <img src="{{ asset('storage/settings/' . $setting?->img_qris) }}"
                class="object-contain mx-auto w-72 h-72">

            <p class="text-sm text-center text-gray-500">
                Silakan scan QR menggunakan aplikasi e-wallet
            </p>

            <div class="flex gap-3">
                <button type="button" id="closeQris"
                    class="w-1/2 py-3 font-bold bg-gray-200 rounded-lg hover:bg-gray-300">
                    Batal
                </button>
                <button type="button" id="confirmQris"
                    class="w-1/2 py-3 font-bold text-white bg-green-600 rounded-lg hover:bg-green-700">
                    Pembayaran Selesai
                </button>
            </div>

        </div>
    </div>



<script>
const productMap = @json($products->mapWithKeys(fn($p)=>[
    $p->id => ['id'=>$p->id,'name'=>$p->name,'price'=>$p->price]
]));

let cart = JSON.parse(localStorage.getItem('cart')) || [];

function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
}
const categoryButtons = document.querySelectorAll('.category-btn');
const productCards = document.querySelectorAll('.product-card');
const submitBtn = document.getElementById('submitBtn');
const cartInput = document.getElementById('cartInput');
const qrisModal = document.getElementById('qrisModal');

categoryButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        const category = btn.dataset.category;

        // Active button
        categoryButtons.forEach(b => {
            b.classList.remove('bg-blue-600', 'text-white');
            b.classList.add('bg-gray-100', 'text-gray-700');
        });

        btn.classList.add('bg-blue-600', 'text-white');
        btn.classList.remove('bg-gray-100', 'text-gray-700');

        productCards.forEach(card => {
            const cardCategory = card.dataset.category;

            if (category === 'all' || cardCategory === category) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    });
});

/* ======================
   CART
====================== */
document.getElementById('productGrid').addEventListener('click', e => {
    const btn = e.target.closest('.add-to-cart-btn');
    if (!btn) return;

    const product = productMap[btn.dataset.id];
    if (!product) return;

    const item = cart.find(i => i.id == product.id);
    item ? item.qty++ : cart.push({...product, qty: 1});

    saveCart();
    updateCart();
});

function updateCart() {
    const items = document.getElementById('cartItems');
    const empty = document.getElementById('emptyCart');
    const summary = document.getElementById('orderSummary');

    if (!cart.length) {
        empty.classList.remove('hidden');
        items.classList.add('hidden');
        summary.classList.add('hidden');
        return;
    }

    empty.classList.add('hidden');
    items.classList.remove('hidden');
    summary.classList.remove('hidden');

    let total = 0;

    items.innerHTML = cart.map((item, i) => {
        total += item.qty * item.price;
        return `
            <div class="flex justify-between p-3 rounded bg-gray-50">
                <div>
                    <p>${item.name}</p>
                    <p class="text-sm">Rp${item.price.toLocaleString()}</p>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="updateQty(${i}, -1)">−</button>
                    <span>${item.qty}</span>
                    <button onclick="updateQty(${i}, 1)">+</button>
                </div>
            </div>`;
    }).join('');

    document.getElementById('subTotal').textContent = total.toLocaleString();
    document.getElementById('grandTotal').textContent = total.toLocaleString();
}

function updateQty(index, diff) {
    cart[index].qty += diff;
    if (cart[index].qty <= 0) cart.splice(index, 1);
    saveCart();
    updateCart();
}

/* ======================
   SUBMIT FLOW
====================== */
submitBtn.addEventListener('click', () => {
    if (!cart.length) {
        alert('Keranjang kosong');
        return;
    }

    cartInput.value = JSON.stringify(cart);

    const paymentMethod = document.querySelector(
        'input[name="payment_method"]:checked'
    )?.value;

    if (!paymentMethod) {
        alert('Pilih metode pembayaran');
        return;
    }

    if (paymentMethod === 'qris') {
        const total = document.getElementById('grandTotal').textContent;
        document.getElementById('qrisTotal').textContent = total;

        qrisModal.classList.remove('hidden');
    } else {
        submitTransaction();
    }
});

function clearCartStorage() {
    cart = [];
    localStorage.removeItem('cart');
    document.getElementById('cartInput').value = '';
    updateCart();
}


document.getElementById('confirmQris').addEventListener('click', () => {
    qrisModal.classList.add('hidden');
    submitTransaction();
});

document.getElementById('closeQris').addEventListener('click', () => {
    qrisModal.classList.add('hidden');
});

function submitTransaction() {
    submitBtn.disabled = true;

    cartInput.value = JSON.stringify(cart);

    const form = document.getElementById('transactionForm');
    const formData = new FormData(form);

    fetch("{{ route('transactions.store') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(async res => {
        const data = await res.json();
        if (!res.ok) throw data;
        return data;
    })
    .then(res => {
        clearCartStorage();
        window.location.href = res.redirect;
    })
    .catch(err => {
        alert(err.message || 'Gagal menyimpan transaksi');
        submitBtn.disabled = false;
    });
}

document.addEventListener('DOMContentLoaded', () => {
    updateCart();
});

document.getElementById('clearCartBtn').addEventListener('click', () => {
    if (!cart.length) return;

    if (confirm('Yakin ingin mengosongkan keranjang?')) {
        clearCartStorage();
    }
});

</script>

</x-app-layout>
