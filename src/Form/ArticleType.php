<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ArticleType
 * @author ereshkidal
 */
class ArticleType extends AbstractType
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'help' => 'Choose something catchy and unique!'
            ])
            ->add('content')
            ->add('publishedAt', DateTimeType::class)
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => static function(User $user) {
                    return sprintf('%s, %s', $user->getUsername(), $user->getEmail());
                },
                'placeholder' => 'Choose an author',
                'choices' => $this->userRepository->findAllUsernameAlphabetical(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
