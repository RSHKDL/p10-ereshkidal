<?php

namespace App\DTO;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserRegistrationDTO
 * @author ereshkidal
 */
final class UserRegistrationDTO
{
    /**
     * @var string $username
     * @Assert\NotBlank(message="Please enter an username")
     */
    public $username;

    /**
     * @var string $email
     * @Assert\NotBlank(message="Please enter an email")
     * @Assert\Email()
     */
    public $email;

    /**
     * @var string $plainPassword
     * @Assert\NotBlank(message="Please enter a password")
     * @Assert\Length(
     *     min="8",
     *     minMessage="The password is too short, it should have at least {{ limit }} characters"
     * )
     * @Assert\Regex(
     *     pattern="/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?!.*\s)/",
     *     message="At least one lowercase, one uppercase, one digit and no space"
     * )
     * @Assert\NotCompromisedPassword()
     */
    public $plainPassword;

    /**
     * @var bool $agreeTerms
     * @Assert\IsTrue(message="You must agree to terms to register")
     */
    public $agreeTerms;

    /**
     * @param self $dto
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return User
     * @throws \Exception
     */
    public static function createNewlyRegisteredUser(self $dto, UserPasswordEncoderInterface $passwordEncoder): User
    {
        $user = new User();
        $user->setUsername($dto->username);
        $user->setEmail($dto->email);
        $user->setPassword($passwordEncoder->encodePassword($user, $dto->plainPassword));
        $user->agreeTerms();

        return $user;
    }
}
