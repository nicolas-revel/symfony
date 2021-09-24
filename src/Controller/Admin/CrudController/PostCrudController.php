<?php

namespace App\Controller\Admin\CrudController;

use DateTime;
use App\Entity\Post;
use App\Entity\User;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function createEntity (string $entityFqcn)
    {
        $post = new Post();
        $post->setCreatedAt(new DateTime("now"));
        $post->setAuthor($this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => 'admin@admin.fr']));

        return $post;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            SlugField::new('slug')->setTargetFieldName('title'),
            TextEditorField::new('content'),
            TextField::new("imageFile", "Image ")->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('image')->setBasePath('/uploads/images/posts')->onlyOnIndex(),
        ];
    }

}
