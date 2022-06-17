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
- ```composer require symfony/ux-twig-component```
- ```composer require symfony/ux-live-component```

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


### 🖥 C'est partie pour la création de notre premier twig component 🔥

1. Dans le dossier `./src/` créer un nouveau dossier `Components` et y ajouter un nouveau fichier `BlogpostComponent.php` et ajouter le code suivant :
```php
<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('blogpost')]
class BlogpostComponent
{
}
```

2. Dans le dossier `./templates/` créer un nouveau dossier `components` et y ajouter un nouveau fichier `blogpost.html.twig` et ajouter le code suivant :
```html
<div class="card m-4">
    <div class="card-body">
        <h5 class="card-title">un titre</h5>
        <p class="card-text">du contenu</p>
    </div>
</div>
```

Nous allons maintenant essayer de comprendre comment le component que nous avons créé fonctionne.

1. Dans le fichier `./templates/blog/index.html.twig` supprime le code généré par défault et remplace le par :
```twig
{% extends 'base.html.twig' %}

{% block title %}Hello BlogController!{% endblock %}

{% block body %}
    {{ component('blogpost') }}
{% endblock %}
```

Rafraichis la page https://127.0.0.1:8000/blog et vois le component qui s'affiche. Pour le moment ce n'est que du contenu en dur mais l'avantage est que le component peut maintenant être appelé dans n'importe quel template, il est réutilisable.

Maintenant que notre composant est en place, nous allons voir comment le rendre plus intelligent.

4. Dans le fichier `./src/Components/BlogpostComponent.php` ajouter le code suivant :
```php
public string $title;
public string $content;
```

5. Et dans le fichier `./templates/blog/index.html.twig` modifier le code en supprimant le contenu en dur par des variables twig :
```html
<div class="card m-4">
    <div class="card-body">
        <h5 class="card-title">{{ title }}</h5>
        <p class="card-text">{{ content }}</p>
    </div>
</div>
```

⛔️ Si tu recharges la page, Symfony lève une erreur car le component s'attend à recevoir des valeurs pour les variables twig `title`et `content` qu'on ne lui a pas encore donné.

6. Dans le fichier `./templates/blog/index.html.twig` modifie le code pour passer au component des valeurs pour le titre et le contenu :
```twig
{% extends 'base.html.twig' %}

{% block title %}Hello BlogController!{% endblock %}

{% block body %}
    {{ component('blogpost', {
        'title': 'My first blogpost',
        'content': 'This is my first blogpost'
    }) }}
{% endblock %}
```

✅ Si tu recharges la page, tu vois le component qui s'affiche avec les nouveaux contenus.

🤨 Tu dois probablement te dire, *"ok, mais c'est toujours du contenu en dur..."* ! Effectivement, il est temps de d'apporter plus de logique afin de récupérer les objets blog depuis la base de données ! 


7. Retournons dans le fichier `./src/Components/BlogpostComponent.php` que nous allons maintenant ajuster pour qu'il récupère un objet blog depuis la base de données.
A noter que le fichier BlogController.php est le "manager" du component blogpost.html.twig, il gère un objet à la fois. 
On va donc effacer le code que nous avons et ajouter à la place une nouvelle propriété privé $id à notre classe, qui représente l'id d'un objet blog. Puis nous allons ajouter une fonction getBlog() qui va se charger de récupérer un objet blog par son id en base de données depuis son Repository.
```php
class BlogpostComponent
{
    public int $id;

    public function __construct(private BlogRepository $blogRepository)
    {}

    public function getBlogpost(): Blog
    {
        return $this->blogRepository->find($this->id);
    }
}
```

8. Dans le fichier './templates/components/blogpost.html.twig' modifions le code comme ceci :
```html
<div class="card m-4">
    <div class="card-body">
        <h5 class="card-title">{{ this.blogpost.title }}</h5>
        <p class="card-text">{{ this.blogpost.content }}</p>
    </div>
</div>
```

>🔖 Utiliser this dans le template fait référence à la classe BlogpostComponent, autrement dit, a partir du this en twig j'ai accès aux méthodes publiques de la classe BlogpostComponent. Ainsi quand j'écris en twig this.blogpost c'est la méthode getBlogpost() du BlogpostComponent.php que se joue et qui renvoit un objet blog. A partir de là je peux aller chercher la propriété de l'objet que je souhaite afficher ce qui donne `{{ this.blogpost.title }}` et `{{ this.blogpost.content }}`.

⛔️ Si tu recharges la page Symfony lève encore une erreur ! En effet le component blogpost.html.twig s'attend maintenant à recevoir un id pour récupérer l'objet en entier et ainsi pourvoir afficher le titre et le content.

1. Adaptons à nouveau notre code et retournons dans le fichier `./templates/blog/index.html.twig`, modifions le code comme ceci :
```twig
{% extends 'base.html.twig' %}

{% block title %}Hello BlogController!{% endblock %}

{% block body %}
    {{ component('blogpost', { 'id': 1 }) }}
{% endblock %}
```

✅ Si tu recharges la page, tu vois le component qui s'affiche avec les contenu du blog id 1 ! 
Notre component est bien plus intelligent maintenant, mais je lui passe toujours une valeur en dur pour l'id... Voyons comment faire pour que tous mes objets blogs soient chargés depuis la base de données.

10.  Dans le dossier `./src/Components` nous allons créer un nouveau fichier `AllBlogpostComponent.php` et ajouter le code suivant :
```php
<?php

namespace App\Components;

use App\Repository\BlogRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('all_blogpost')]
class AllBlogpostComponent
{
    public function __construct(private BlogRepository $blogRepository)
    {}

    public function getAllBlogpost(): array
    {
        return $this->blogRepository->findAll();
    }
}
```

Cette classe permet de récupérer tous les objets blog depuis la base de données.

🧐 Remarque : 
Lorsque l'on crée une classe qui gère un componant, on fait bien attention de nommer dans notre annotation @AsTwigComponent le nom du componant que l'on veut créer et ensuite de créer le fichier html.twig du même nom. <br>
Ex : <br>
`@AsTwigComponent('all_blogpost')` => `./templates/components/all_blogpost.html.twig` <br>
`@AsTwigComponent('blogpost')` => `./templates/components/blogpost.html.twig` <br>

11. Créons maintenant le fichier `./templates/components/all_blogpost.html.twig` et ajoutons le code suivant :
```twig
{% for blogpost in this.allBlogpost %}
    {{ component('blogpost', { 'id': blogpost.id }) }}
{% endfor %}
```

Ce nouveau component se charge de récupérer tous les objets blog depuis la base de données et de les repasser à notre premier component blogpost.html.twig qui se charge lui même d'afficher les données de chacun des objets à chaque tour de boucle.

12.  Enfin nous allons ajuster le fichier `./templates/blog/index.html.twig` :
```twig
{% extends 'base.html.twig' %}

{% block title %}Hello BlogController!{% endblock %}

{% block body %}
    {{ component('all_blogpost') }}
{% endblock %}
```

✅ En rechargeant la page, on peut voir maintenant que tous nos objets blog s'affichent ! <br>

#### Pour conclure avec les twig components:
> L'avantage d'utiliser des twig components est que le code est plus maintenable et *SOLID* : <br>
> Si je souhaite changer le design de l'affichage d'un blog, je modifie seulement blogpost.html.twig<br>
> Si je souhaite changer la manière dont j'itère sur les objets blog, je modifie seulement le code du component all_blogpost.html.twig. <br>
> Si je souhaite ajouter des fonctionnalités (CRUD par ex) à mon objet blog alors je modifie le code des classes BlogpostComponent et ou AllBlogpostComponent. <br>
> Etc ... <br>
> Cependant, il faut garder à l'esprit que c'est une fonctionnalité qui reste pour le moment encore experimentale dans symfony. <br>
> Mais vu comment c'est pratique il y a quand même peut-être une chance que ça soit maintenu et même amélioré dans les prochaines versions de symfony.

### 🖥 C'est partie pour les live components 🔥
[...wip]

Voyons maintenant les live components, une fonctionnalité également récemment introduite dans symfony qui nous permet d'avoir des composants réactifs sans une ligne de javascript ! <br>

1. Première étape, la partie php :

- Dans le dossier `./src/Components` nous allons créer un nouveau fichier `BlogpostSearchComponent.php` et ajouter le code suivant :
```php
<?php

namespace App\Components;

use App\Repository\BlogRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('blogpost_search')]
class BlogpostSearchComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    public function __construct(private BlogRepository $blogRepository) {}

    public function getBlogposts(): void
    {
        // ::TODO écrire la fonction dans le blogRepository
        $this->blogRepository->findByQuery($this->query);
    }
}
```

2. Dans le fichier `./src/Repository/BlogRepository.php` ajouter la méthode qui permet de récupérer les objets blog qui correspondent à la recherche.
```php
public function findByQuery(string $query): array
{
    if (empty($query)) return [];

    return $this->createQueryBuilder('b')
        ->andWhere('b.title LIKE :query')
        ->setParameter('query', '%' . $query . '%')
        ->getQuery()
        ->getResult()
    ;
}
```

3. Dans le dossier `./templates/components` créer un nouveau fichier `blogpost_search.html.twig` et ajouter le code suivant :
```html
<div {{ attributes }} class="m-4">
    <input 
        type="search"
        name="query"
        value="{{ query }}"
        data-action="live#update"
    >

    {% for blogpost in this.blogposts %}
        {{ component('blogpost', { 'id' : blogpost.id }) }}
    {% endfor %}
</div>
```

3. Dans le controller `./src/Controller/BlogController.php` ajouter le code suivant :
```php
#[Route('/search', name: 'app_search')]
public function search(): Response
{
    return $this->render('blog/search.html.twig');
}
```

4. Dans le dossier `./templates/blog` créer un nouveau fichier `search.html.twig` et ajouter le code suivant :
```html
{% extends 'base.html.twig' %}

{% block title %}Search{% endblock %}

{% block body %}
    {{ component('blogpost_search') }}
{% endblock %}
```

✅ On peut maintenant se rendre sur la page `/search` et faire une recherche ! <br>
Les objets sont mis à jour automatiquement lorsque le champ de recherche change. <br>
Sans avoir écrit un seule ligne de javascript 🙌  <br>

#### 🖥 Edit Blog - Live Component 🔥

[...wip]
Nous allons maintenant allé un peu plus loin et créer un nouveau component qui permet de modifier un blog sans rechargement de la page. <br>
L'idée est de pouvoir être en mode édition d'un blog tout en pouvant visualisé les modifications qui sont faites en temps réel, toujours sans une seule ligne de javascript ! <br>

C'est partie ! 

1. Dans le dossier `./src/Components` nous allons créer un nouveau fichier `EditBlogpostComponent.php` et ajouter le code suivant :
```php
<?php

namespace App\Components;

use App\Entity\Blog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;

#[AsLiveComponent('edit_blogpost')]
final class EditBlogpostComponent extends AbstractController {
    
    use DefaultActionTrait;

    use ValidatableComponentTrait;

    #[LiveProp(exposed: ['title', 'content'])]
    #[Assert\Valid]
    public Blog $blogpost;

    public bool $isSaved = false;

    #[LiveAction]
    public function save(EntityManagerInterface $em) {
        $this->validate();

        $this->isSaved = true;
        $em->flush();
    }
}
```

2. Dans le dossier './template/components' créer un nouveau fichier `edit_blogpost.html.twig` et ajouter le code suivant :
```html
<div {{ attributes }}>
    <div>
        <h1>{{blogpost.title}}</h1>
        <hr>
        <!-- title field -->
        <div class="mb-3">
            <label for="blogpost_title" class="form-label">
                <h2>Title</h2>
            </label>
            <div class="input-group">
                <input type="text" data-model="blogpost.title" data-action="live#update" class="form-control"
                    value="{{ blogpost.title }}" id="blogpost_title">
            </div>
        </div>
        <!-- content field -->
        <div class="mb-3">
            <label for="blogpost_content" class="form-label">
                <h2>Content</h2>
            </label>
            <div class="input-group">
                <textarea type="text" data-model="blogpost.content" data-action="live#update" class="form-control"
                    value="{{ blogpost.title }}" id="blogpost_content">{{ blogpost.content }}</textarea>
            </div>
        </div>
    </div>

    <!-- Display preview -->
    <div class="my-5 p-5 shadow bg-secondary text-light">
        <h3>{{ blogpost.title }}</h3>
        {{ blogpost.content }}
    </div>

    <!-- Save Action -->
    <div class="d-grid gap-2">
        <button data-action="live#action" data-action-name="save" class="btn btn-primary btn-sm">Enregistrer les
            modifications</button>
    </div>

    <!-- Display success -->
    {% if isSaved %}
    <div class="alert alert-success my-4">Enregistré !</div>
    {% endif %}

</div>
```

3. Dans le controller `./src/Controller/BlogController.php` ajouter le code suivant :
```php
#[Route('/edit/{id}', name: 'app_edit')]
public function edit(Blog $blogpost): Response
{
    return $this->render('blog/edit.html.twig', [
        'blogpost' => $blogpost,
    ]);
}
```

4. Dans le dossier `./templates/blog` créer un nouveau fichier `edit.html.twig` et ajouter le code suivant :
```twig
{% extends 'base.html.twig' %}

{% block title %}Blog{% endblock %}

{% block body %}
<div class="container">
    {{ component('edit_blogpost', { blogpost : blogpost }) }}
</div>
{% endblock %}
```

✅ On peut maintenant se rendre sur la page `/edit` et tester notre nouvelle fonctionnalité ! <br>
L'objet est mis à jour en mode edition et préview !<br>
Sans avoir écrit un seule ligne de javascript encore une fois 🙌 <br>