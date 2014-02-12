<?php

/**
 * Fichier : /Model/Entity/Client.php
 * Description : Entité client
 * Auteur Florian Martinelli
 * Date : 10/02/2014
 */

namespace Model\Entity;

use Library\Utils;
use Library\AbstractEntity;
use DateTime;
use InvalidArgumentException;

class Client extends AbstractEntity
{
    protected $username;
    protected $password;
    protected $email;
    protected $token;
    protected $salt;
    protected $date_subscribed;
    protected $roles = array();

    protected $lastname;
    protected $firstname;
    protected $address;
    protected $postal_code;
    protected $city;
    protected $country;

    public function __construct($data = array())
    {
        $this->setDate_subscribed(new DateTime());

        $this->setNewToken();
        $this->setNewSalt();

        parent::__construct($data);
    }

    /**
     * Gets the value of username.
     *
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Sets the value of username.
     *
     * @param mixed $username the username
     *
     * @return self
     */
    public function setUsername($username)
    {
        if (!is_string($username)) {
            throw new InvalidArgumentException('$username must be a string');
        }

        $this->username = $username;

        return $this;
    }

    /**
     * Gets the value of password.
     *
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets the value of password.
     *
     * @param mixed $password the password
     *
     * @return self
     */
    public function setPassword($password)
    {
        if (!is_string($password)) {
            throw new InvalidArgumentException('$password must be a string');
        }

        $this->password = $password;

        return $this;
    }

    /**
     * Gets the value of email.
     *
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the value of email.
     *
     * @param mixed $email the email
     *
     * @return self
     */
    public function setEmail($email)
    {
        if (!is_string($email)) {
            throw new InvalidArgumentException('$email must be a string');
        }

        $this->email = $email;

        return $this;
    }

    /**
     * Gets the value of token.
     *
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Sets the value of token.
     *
     * @param mixed $token the token
     *
     * @return self
     */
    public function setToken($token)
    {
        if (!is_string($token)) {
            throw new InvalidArgumentException('$token must be a string');
        }

        $this->token = $token;

        return $this;
    }

    /**
     * Sets a new value of token.
     *
     * @param void
     *
     * @return self
     */
    public function setNewToken()
    {
        $this->setToken( Utils::generateString(64) );

        return $this;
    }

    /**
     * Gets the value of salt.
     *
     * @return mixed
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Sets the value of salt.
     *
     * @param mixed $salt the salt
     *
     * @return self
     */
    public function setSalt($salt)
    {
        if (!is_string($salt)) {
            throw new InvalidArgumentException('$salt must be a string');
        }

        $this->salt = $salt;

        return $this;
    }

    /**
     * Sets a new value of salt.
     *
     * @param void
     *
     * @return self
     */
    public function setNewSalt()
    {
        $this->setSalt( Utils::generateString(32) );

        return $this;
    }

    /**
     * Gets the value of date_subscribed.
     *
     * @return mixed
     */
    public function getDate_subscribed($sql = false)
    {
        if ($sql === false) {
            return $this->date_subscribed->format('d/m/Y H:i:s');
        }
        else {
            return $this->date_subscribed->format('Y/m/d H:i:s');
        }
    }

    /**
     * Sets the value of date_subscribed.
     *
     * @param mixed $date_subscribed the date_subscribed
     *
     * @return self
     */
    public function setDate_subscribed($date_subscribed)
    {
        if(is_string($date_subscribed))
        {
            $date_subscribed = new DateTime($date_subscribed);
        }

        $this->date_subscribed = $date_subscribed;

        return $this;
    }

    /**
     * Gets the value of roles.
     *
     * @return mixed
     */
    public function getRoles($sql = false)
    {
        if ($sql === false) {
            return $this->roles;
        }
        else {
            return implode(',', $this->roles);
        }
    }

    /**
     * Sets the value of roles.
     *
     * @param mixed $roles the roles
     *
     * @return self
     */
    public function setRoles($roles)
    {
        if(is_string($roles))
        {
            $roles = explode(',', $roles);
        }

        $this->roles = $roles;

        return $this;
    }

    /**
     * Add a role
     *
     * @param string $role the role
     *
     * @return self
     */
    public function addRole($role)
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * Gets the value of lastname.
     *
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Sets the value of lastname.
     *
     * @param mixed $lastname the lastname
     *
     * @return self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Gets the value of firstname.
     *
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Sets the value of firstname.
     *
     * @param mixed $firstname the firstname
     *
     * @return self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Gets the value of address.
     *
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets the value of address.
     *
     * @param mixed $address the address
     *
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Gets the value of postal_code.
     *
     * @return mixed
     */
    public function getPostal_code()
    {
        return $this->postal_code;
    }

    /**
     * Sets the value of postal_code.
     *
     * @param mixed $postal_code the postal_code
     *
     * @return self
     */
    public function setPostal_code($postal_code)
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    /**
     * Gets the value of city.
     *
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets the value of city.
     *
     * @param mixed $city the city
     *
     * @return self
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Gets the value of country.
     *
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Sets the value of country.
     *
     * @param mixed $country the country
     *
     * @return self
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }
}