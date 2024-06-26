<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Vente</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <h1>Bienvenue chez Audi d'occasions</h1>
        </nav>
        <div class="search-container">
            <input type="text" id="search-bar" placeholder="Rechercher un article...">
        </div>
        <div id="cart">
            <button id="cart-button" onclick="toggleCart()">Panier<span id="cart-count">
                <?php
                // Afficher le nombre total d'articles dans le panier
                echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
                ?>
            </span></button>
        </div>
    </header>
    <main>
        <section id="products">
            <?php
            include 'config.php'; // Inclure le fichier de configuration de la base de données

            // Préparer et exécuter une requête pour récupérer les produits
            $stmt = $conn->prepare("SELECT * FROM products");
            $stmt->execute();
            $products = $stmt->fetchAll();

            // Boucler sur les produits et les afficher
            foreach ($products as $product) {
                echo "
                <article class='product'>
                    <img src='{$product['image']}' alt='{$product['name']}'>
                    <h2>{$product['name']}</h2>
                    <p>Prix: {$product['price']} €</p>
                    <form method='POST' action='cart.php'>
                        <input type='hidden' name='name' value='{$product['name']}'>
                        <input type='hidden' name='price' value='{$product['price']}'>
                        <input type='hidden' name='image' value='{$product['image']}'>
                        <button type='submit' name='add_to_cart'>Ajouter au panier</button>
                    </form>
                </article>
                ";
            }
            ?>
        </section>
    </main>
    <div id="cart-menu">
        <button class="close-button" onclick="closeCart()">×</button>
        <ul id="cart-items">
            <?php
            // Afficher les articles dans le panier
            if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item) {
                    echo "
                    <li>
                        <div class='cart-item-info'>
                            <img src='{$item['image']}' alt='{$item['name']}' class='cart-item-image'>
                            <div class='cart-item-details'>
                                <span class='cart-item-name'>{$item['name']}</span>
                                <span class='cart-item-price'>{$item['totalPrice']} €</span>
                            </div>
                        </div>
                        <div class='quantity-control'>
                            <form method='POST' action='cart.php'>
                                <input type='hidden' name='name' value='{$item['name']}'>
                                <input type='hidden' name='price' value='{$item['price']}'>
                                <input type='hidden' name='image' value='{$item['image']}'>
                                <button type='submit' name='add_to_cart'>+</button>
                            </form>
                            <form method='POST' action='cart.php'>
                                <input type='hidden' name='name' value='{$item['name']}'>
                                <button type='submit' name='remove_from_cart'>-</button>
                            </form>
                        </div>
                    </li>
                    ";
                }
            }
            ?>
        </ul>
        <p>Montant total: <span id="total-cart-amount">
            <?php
            // Calculer et afficher le montant total du panier
            echo array_sum(array_column($_SESSION['cart'], 'totalPrice'));
            ?> €
        </span></p>
        <button onclick="validatePayment()">Commander</button>
    </div>
    <script>
        // Fonction pour afficher/masquer le menu du panier
        function toggleCart() {
            const cartMenu = document.getElementById('cart-menu');
            cartMenu.classList.toggle('visible');
        }

        // Fonction pour fermer le menu du panier
        function closeCart() {
            const cartMenu = document.getElementById('cart-menu');
            cartMenu.classList.remove('visible');
        }

        // Fonction pour rediriger vers la page de paiement PayPal
        function validatePayment() {
            window.location.href = 'https://www.paypal.com/signin';
        }
    </script>
</body>
</html>
