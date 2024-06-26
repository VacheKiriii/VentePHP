<?php
session_start();

// Vérifier si le panier existe dans la session, sinon le créer
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Fonction pour ajouter un article au panier
function addToCart($name, $price, $image) {
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['name'] === $name) {
            // Si l'article est déjà dans le panier, augmenter la quantité
            $item['quantity']++;
            $item['totalPrice'] += $price;
            return;
        }
    }
    // Si l'article n'est pas dans le panier, l'ajouter
    $_SESSION['cart'][] = ['name' => $name, 'price' => $price, 'quantity' => 1, 'totalPrice' => $price, 'image' => $image];
}

// Fonction pour retirer un article du panier
function removeFromCart($name) {
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['name'] === $name) {
            if ($item['quantity'] === 1) {
                // Si la quantité est 1, supprimer l'article du panier
                unset($_SESSION['cart'][$key]);
            } else {
                // Sinon, réduire la quantité de l'article
                $_SESSION['cart'][$key]['quantity']--;
                $_SESSION['cart'][$key]['totalPrice'] -= $item['price'];
            }
            return;
        }
    }
}

// Vérifier si une requête POST est reçue pour ajouter ou retirer des articles
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        addToCart($_POST['name'], $_POST['price'], $_POST['image']);
    }
    if (isset($_POST['remove_from_cart'])) {
        removeFromCart($_POST['name']);
    }
    // Rediriger vers la page précédente après l'ajout ou le retrait d'un article
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
