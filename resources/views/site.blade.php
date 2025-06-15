<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>COD Points Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-gray-100">

<!-- Navbar -->
<nav class="bg-gray-900 shadow-md border-b border-gray-700">
    <div class="container mx-auto flex items-center justify-between py-4 px-6">
        <a href="#" class="text-2xl font-bold text-green-400 tracking-wide">COD Shop<small> made by salman osama</small></a>
        <div class="hidden md:flex space-x-6">
            <a href="#" class="text-gray-300 hover:text-green-400">Home</a>
            <a href="#" class="text-gray-300 hover:text-green-400">Cards</a>
            <a href="#" class="text-gray-300 hover:text-green-400">Cart</a>
            <a href="#" class="text-gray-300 hover:text-green-400">Support</a>
        </div>
        <div class="md:hidden">
            <button class="text-gray-300 focus:outline-none">
                ☰
            </button>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="relative bg-gray-800 text-white py-20 border-b border-gray-700">
    <div class="container mx-auto text-center">
        <h1 class="text-4xl font-extrabold mb-4 text-green-400">Buy COD Points Instantly</h1>
        <p class="text-lg mb-6 text-gray-300">Choose from a variety of Call of Duty points packages.</p>
        <a href="#card-list" class="bg-green-500 text-black px-6 py-2 rounded-lg font-semibold hover:bg-green-400">Shop Now</a>
    </div>
</div>

<!-- Card Packages -->
<div class="container mx-auto py-12 px-6">
    <h2 class="text-3xl font-bold mb-8 text-center text-green-400">Available Packages</h2>
    <div id="card-list" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach ($cards as $card)
            <div class="bg-gray-900 border border-gray-700 rounded-lg shadow-lg p-4 hover:shadow-green-400/50 transition duration-300">
                <div class="flex flex-col items-center">
                    <h3 class="text-xl font-semibold text-white">{{ $card->value }} COD Points</h3>
                    <p class="text-lg font-bold text-green-400 mt-2">${{ number_format($card->price, 2) }}</p>
                    <div class="mt-4 flex gap-2">
                        <button onclick="viewCard({{ $card->id }})"
                                class="bg-green-500 text-black px-4 py-2 rounded hover:bg-green-400 transition">
                            View
                        </button>
                        <button onclick="addToCart({{ $card->id }})"
                                class="bg-yellow-500 text-black px-4 py-2 rounded hover:bg-yellow-400 transition">
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-8 border-t border-gray-700">
    <div class="container mx-auto text-center">
        <p class="mb-4 text-gray-400">&copy; 2025 COD Shop. All rights reserved.</p>
        <div class="flex justify-center space-x-4">
            <a href="#" class="hover:text-green-400">Privacy Policy</a>
            <a href="#" class="hover:text-green-400">Terms</a>
            <a href="#" class="hover:text-green-400">Contact</a>
        </div>
    </div>
</footer>

<!-- JS -->
<script>
    const cards = @json($cards);

    function viewCard(id) {
        alert('View card ' + id);
    }

    function addToCart(id) {
        const card = cards.find(c => c.id === id);
        alert(`${card.value} COD Points added to cart.`);
    }
</script>

</body>
</html>
