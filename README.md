```
  ______   __     __              __        _______    ______   _______ ________  ________   ______   __       ______   ______  
 /      \ |  \   |  \            /  \      |       \  /      \ |       \        \|        \ /      \ |  \     |      \ /      \ 
|  $$$$$$\| $$   | $$           /  $$      | $$$$$$$\|  $$$$$$\| $$$$$$$\$$$$$$$$| $$$$$$$$|  $$$$$$\| $$      \$$$$$$|  $$$$$$\
| $$   \$$| $$   | $$          /  $$       | $$__/ $$| $$  | $$| $$__| $$ | $$   | $$__    | $$  | $$| $$       | $$  | $$  | $$ 
| $$       \$$\ /  $$         /  $$        | $$    $$| $$  | $$| $$    $$ | $$   | $$  \   | $$  | $$| $$       | $$  | $$  | $$ 
| $$   __   \$$\  $$         /  $$         | $$$$$$$ | $$  | $$| $$$$$$$\ | $$   | $$$$$   | $$  | $$| $$       | $$  | $$  | $$ 
| $$__/  \   \$$ $$         /  $$          | $$      | $$__/ $$| $$  | $$ | $$   | $$      | $$__/ $$| $$_____ _| $$_ | $$__/ $$ 
 \$$    $$    \$$$         |  $$           | $$       \$$    $$| $$  | $$ | $$   | $$       \$$    $$| $$     \   $$ \ \$$    $$ 
  \$$$$$$      \$           \$$             \$$        \$$$$$$  \$$   \$$  \$$    \$$        \$$$$$$  \$$$$$$$$\$$$$$$  \$$$$$$ 
```
## Description
**CV / PORTFOLIO** est une plateforme web conçue pour permettre aux utilisateurs de mettre en valeur leurs expériences professionnelles et projets. Ce site offre une interface conviviale où les utilisateurs peuvent créer et personnaliser leur CV, ainsi que gérer leurs projets.

## Fonctionnalités
- **Gestion des utilisateurs :** Chaque utilisateur peut créer un compte, se connecter et gérer son profil.
- **Personnalisation du CV :** Les utilisateurs peuvent changer le style de leur CV selon leurs préférences, incluant des options de mise en page et de couleurs.
- **Dépôt de projets :** Les utilisateurs peuvent soumettre des projets avec des descriptions, des liens et des images pour mettre en avant leurs réalisations.
- **Contact avec les administrateurs :** Un formulaire de contact permet aux utilisateurs de poser des questions ou de signaler des problèmes.

## Installation
Pour installer le projet sur votre machine locale, suivez les étapes ci-dessous :

1. **Clonez le repository :**
    ```bash 
    git clone https://github.com/QuentinDrgn/PHP.git
2. **Accédez au répertoire du projet :**
    ```bash
    cd docker
3. **Installez les dépendances PHP :**  
   Assurez-vous d'avoir PHP et C
   ```bash
   composer install
4. **Lancez Docker :**  
   Assurez-vous que Docker est en cours d'exécution et exécutez :
   ```bash
   docker-compose up
5. **Accédez à l'application :**  
   Une fois Docker lancé, ouvrez votre navigateur et allez à l'adresse suivante :
   [http://127.0.0.1/](http://127.0.0.1/)

## Utilisation
- **Accès au site :**  
  Vous pouvez accéder au site à l'adresse [http://127.0.0.1/](http://127.0.0.1/). Inscrivez-vous ou connectez-vous pour commencer à utiliser la plateforme.

- **Accès à la base de données :**  
  Pour interagir avec la base de données, ajoutez `:8080` à l'adresse ci-dessus. Vous pourrez ainsi accéder à l'interface de gestion de votre base de données.

- **Vérification des mails reçus :**  
  Pour voir les mails reçus (fonctionnalité en cours de développement), accédez au port `8025` en utilisant l'adresse :
  [http://127.0.0.1:8025](http://127.0.0.1:8025).

## Technologies
Ce projet utilise les technologies suivantes :
- **Docker** : Pour la containerisation de l'application. ( 27.2.0)
- **PHP** : Pour le backend de l'application. (8.2.12 )
- **JavaScript** : Pour les interactions côté client. (21.6.1)
- **HTML** et **CSS** : Pour la structure et le style du site.

## Contributions
Les contributions sont les bienvenues ! Si vous souhaitez contribuer au projet, veuillez m'envoyer un mail à [quentin.dorigny@ynov.com](mailto:votre_email@example.com). N'hésitez pas à proposer des améliorations, des corrections de bugs ou des fonctionnalités supplémentaires.


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

## Description
**CV / PORTFOLIO** is a web platform designed to allow users to showcase their work experiences and projects. This site offers a user-friendly interface where users can create and customize their resume, as well as manage their projects.

## Features
- **User Management:** Each user can create an account, log in and manage their profile.
-**Resume Customization:** Users can change the style of their resume according to their preferences, including layout and color options.
- **Project Submission:** Users can submit projects with descriptions, links and images to highlight their achievements.
- **Contact Administrators:** A contact form allows users to ask questions or report issues.

## Installation
To install the project on your local machine, follow these steps:

1. **Clone the repository:**
    `bash 
    git clone https://github.com/QuentinDrgn/PHP.git
2. **Access the project directory:**
    `bash
    cd docker
3. **Install PHP dependencies:**  
   Make sure you have PHP and C
   `bash
   compose install
4. **Launch Docker:**  
   Make sure that Docker is running and run:
   `bash
   docker-compose up
5. **Go to the app:**  
   Once Docker is launched, open your browser and go to:
   [http://127.0.0.1/](http://127.0.0.1/)

## Usage
- **Site access:**  
  You can access the site at [http://127.0.0.1/](http://127.0.0.1/). Sign up or log in to start using the platform.

- **Database access:**  
  To interact with the database, add `:8080` to the address above. You will be able to access the management interface of your database.

  - **Check received emails:**  
  To view incoming emails (feature under development), access port `8025` using the address:
  [http://127.0.0.1:8025](http://127.0.0.1:8025).

## Technologies
This project uses the following technologies:
- **Docker** : For application containerization. ( 27.2.0)
- **PHP** : For the application backend. (8.2.12 )
- **JavaScript*: For client-side interactions. (21.6.1)
- ***HTML** and **CSS** : For site structure and style.

## Contributions
Contributions are welcome! If you would like to contribute to the project, please email me at [quentin.dorigny@ynov.com](mailto:votre_email@example.com). Feel free to suggest improvements, bug fixes or additional features.
