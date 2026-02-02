# 🎮 Magasin de jeux

Projet de site web développé en **PHP / MySQL** permettant d’afficher un catalogue de jeux/jouets avec une gestion de commentaires et un accès administrateur sécurisé.

---

## 🚀 Fonctionnalités

- Page d’accueil
- Boutique avec liste des jeux
- Page produit détaillée
- Système de commentaires
- Connexion administrateur sécurisée
- Suppression des commentaires (admin uniquement)

---

## 🔐 Sécurité

- Connexion à la base de données via PDO
- Requêtes préparées
- Protection XSS avec `htmlspecialchars`
- Mot de passe administrateur hashé avec `password_hash`
- Vérification sécurisée avec `password_verify`
- Sessions PHP sécurisées

---

## 🛠️ Technologies utilisées

- PHP
- MySQL
- HTML5
- CSS3

---

## 📂 Structure du projet

```
magasin-jeux/
│
├── css/
│ └── style.css
├── images/
├── includes/
│ ├── db.php
│ └── header.php
│
├── index.php
├── boutique.php
├── produit.php
├── commentaires.php
├── contact.php
├── README.md
└── .gitignore
```