## Veille Symfony UX TWIG & LIVE COMPONENTS 🔥
16/06/2022

📌 Documentation [Symfony UX](https://symfony.com/doc/current/frontend/ux.html) <br>
📌 Documentation [Twig Components](https://symfony.com/bundles/ux-twig-component/current/index.html) <br>
📌 Documentation [Live Components](https://symfony.com/bundles/ux-live-component/current/index.html) <br>


### Installation du projet :

##### ➜ Créer une nouvelle webapp Symfony :
```symfony new veille-twig-component --webapp```
    
##### ➜ Créer une base de données :
  - Créer un nouveau fichier à la racine du projet nommé ```.env.local```:
  - Dans ```.env.local``` ajouter la variable ```DATABASE_URL``` et les identifiants de connexion à la base de données ainsi que le nom de la base de données que l'on souhaite créer.
  ```DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7&charset=utf8mb4"```
  - Créer la base de données en exécutant : ```bin/console d:d:c```

##### ➜ Créer des fixtures :
  - installer orm-fixtures : ```composer require --dev orm-fixtures```
  - installer Faker : ```composer require fakerphp/faker```
  - remplacer le code du fichier `./src/DataFixtures/AppFixtures.php`, par le code suivant :
```php
    <?php

    namespace App\DataFixtures;

    use App\Entity\Blog;
    use Doctrine\Persistence\ObjectManager;
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use Faker;

    class AppFixtures extends Fixture
    {
        public function load(ObjectManager $manager): void
        {
            $faker = Faker\Factory::create();

            for ($i = 0; $i < 10; $i++) {
                $blog = new Blog();
                $blog
                    ->setTitle($faker->sentence)
                    ->setContent($faker->paragraph);

                $manager->persist($blog);
            }

            $manager->flush();
        }
    }
```

  - Éxécuter les fixtures : ```bin/console d:f:load --no-interaction``` 
  
##### ➜ Créer un controller :
```bin/console m:controller Blog```

##### ➜ Créer une entité Blog : {`id`, `title`, `content`}
```bin/console m:entity```

##### ➜ Créer le script de migration :
```bin/console make:migration```
##### ➜ Exécuter le script de migration :
```bin/console doctrine:migrations:migrate```

##### ➜ Ajouter le CDN bootstrap dans le fichier `./templates/base.html.twig` :
```html
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
```

### 📍 Installer symfony/ux-twig-component & symfony/ux-live-components :
```composer require symfony/ux-twig-component```
```composer require symfony/ux-live-component```

##### ➜ Configuration :
  - Dans le fichier `./assets/bootstrap.js` ajouter le code suivant:

```js
import LiveController from '@symfony/ux-live-component';
import '@symfony/ux-live-component/styles/live.css';

app.register('live', LiveController);
```

*Les dépendances que l'on installe vont générer du javascript, nous sommes donc invités à charger les librairies js avec npm ou yarn.*

##### ➜ Installer les librairies js et lancer un premier build :
```npm install --force && npm run build```

> *Depuis symfony 6, webpack est embarqué et configuré, il suffit simplement de télécharger les dépendances js avec npm ou yarn.*

>❗️ Attention❗️ 
>Il faut toujours utiliser **le même gestionnaire de dépendances** au sein d'un projet, c'est à dire que si tu choisis yarn install au début, tu n'utilises que yarn mais jamais npm. Si tu utilises npm à des moments et yarn à d'autres, cela va créer des conflits 🧨 entre le ```package.json``` et le ```yarn.lock``` et ça c'est pas cool 😒


##### 📌 Démarrer le projet :
- Lancer le serveur web :
 ```symfony server:start```

- Écouter les modifications du dossier `./assets` :
 ```npm run watch```


### C'est partie pour notre premier live component 🔥