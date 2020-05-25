<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
     * @param FormBuilderInterface $builder
     * @param array $options
     * @throws \Exception
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Article|null $article */
        $article = $options['data'] ?? null;
        $isEdit = $article && $article->getId();
        $status = $article ? $article->getStatus() : null;

        $builder
            ->add('title', TextType::class, [
                'help' => 'Choose something catchy and unique!'
            ])
            ->add('content', TextareaType::class, [
                'rows' => 10
            ])
            ->add('author', UserSelectTextType::class, [
                'disabled' => $isEdit
            ])
            ->add('publishOptions', ChoiceType::class, [
                'label' => 'Choose when to publish the article',
                'data' => $status ?? Article::STATUS_PUBLISHED,
                'mapped' => false,
                'required' => true,
                'disabled' => $status === Article::STATUS_PUBLISHED,
                'choices' => [
                    'Publish now' => Article::STATUS_PUBLISHED,
                    'Publish later' => Article::STATUS_SCHEDULED,
                    'Save as a draft' => Article::STATUS_DRAFT
                ]
            ])
            ->add('publishedAt', DateTimeType::class, [
                'label' => 'Choose a publication date',
                'required' => false,
                'data' => $isEdit ? $article->getPublishedAt() : new \DateTime()
            ]);

            /*
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => static function(User $user) {
                    return sprintf('%s, %s', $user->getUsername(), $user->getEmail());
                },
                'placeholder' => 'Choose an author',
                'choices' => $this->userRepository->findAllUsernameAlphabetical(),
            ])*/
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
