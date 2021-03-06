<?php

/**
 * Fichier : /Model/Manager/Client.php
 * Description : Manager des clients
 * Auteur Florian Martinelli
 * Date : 10/02/2014
 */

namespace Model\Manager;

use PDO;
use Library\Utils;
use Library\AbstractManager;
use Library\AbstractEntity;
use Model\Entity\Client;
use DateTime;

class ClientManager extends AbstractManager
{
    public function select($id)
    {
        $request = $this->dao->prepare('SELECT * FROM client WHERE id = :id');
        $request->bindValue(':id', $id);
        $request->execute();

        if(($result = $request->fetch()) != false)
        {
            return new CLient($result);
        }
        else
        {
            return false;
        }

        
    }

    public function selectByUsername($username)
    {
        $request = $this->dao->prepare('SELECT COUNT(id) FROM client WHERE username = :username');
        $request->bindValue(':username', $username);
        $request->execute();

        $result = $request->fetchColumn();

        return $result;
    }

    public function selectByEmail($email)
    {
        $request = $this->dao->prepare('SELECT COUNT(id) FROM client WHERE email = :email');
        $request->bindValue(':email', $email);
        $request->execute();

        $result = $request->fetchColumn();

        return $result;
    }

    public function selectAll()
    {
        $request = $this->dao->prepare('SELECT * FROM client');
        $request->execute();

        $results = $request->fetchAll();

        $clients_list = array();

        foreach ($results as $result)
        {
            $clients_list[] = new Client($result);
        }

        return $clients_list;
    }

    public function insert(AbstractEntity $client)
    {
        $request = $this->dao->prepare('INSERT INTO client SET username = :username, password = :password, email = :email, date_subscribed = :date_subscribed, token = :token, salt = :salt');
        $request->bindValue('username', $client->getUsername());
        $request->bindValue('password', Utils::hashString($client->getPassword()));
        $request->bindValue('email',    $client->getEmail());
        $request->bindValue('date_subscribed', $client->getDate_subscribed(false));
        $request->bindValue('token',    $client->getToken());
        $request->bindValue('salt',     $client->getSalt());
        $request->execute();

    }

    public function update(AbstractEntity $client)
    {
        $request = $this->dao->prepare('UPDATE client
                                        SET username = :username,
                                            password = :password,
                                            email = :email,
                                            date_subscribed = :date_subscribed,
                                            token = :token,
                                            salt = :salt
                                        WHERE id = :id');

        $request->bindValue('username',        $client->getUsername());
        $request->bindValue('password',        Utils::hashString($client->getPassword()));
        $request->bindValue('email',           $client->getEmail());
        $request->bindValue('date_subscribed', $client->getDate_subscribed(false));
        $request->bindValue('token',           $client->getToken());
        $request->bindValue('salt',            $client->getSalt());
        $request->bindValue('id',              $client->getId(), PDO::PARAM_INT);

        $request->execute();
    }

    public function delete($id)
    {
        $request = $this->dao->prepare('DELETE FROM client WHERE id = :id');
        $request->bindValue(':id', $id);
        $request->execute();
    }

    public function installTable()
    {
        $request = $this->dao->prepare('CREATE TABLE IF NOT EXISTS `client` (
                                  `id` int(11) NOT NULL AUTO_INCREMENT,
                                  `username` varchar(255) NOT NULL,
                                  `password` varchar(255) NOT NULL,
                                  `email` varchar(255) NOT NULL,
                                  `date_subscribed` datetime NOT NULL,
                                  `token` varchar(255) NOT NULL,
                                  `salt` varchar(255) NOT NULL,
                                  PRIMARY KEY (`id`)
                                ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');
        $request->execute();
    }

    public function dummyClients($number)
    {
        for($i = 0; $i < $number; $i++)
        {
            $client = new CLient();

            $client->setUsername(Utils::randomLipsum(1, 'words'));
            $client->setPassword('test');
            $client->setEmail(Utils::randomLipsum(1, 'words') . '@hotmail.fr');
            $client->setDate_subscribed(new DateTime( mt_rand(2012, 2013) . '-' . mt_rand(1, 12) . '-'. mt_rand(1, 28)));

            $this->insert($client);
        }
    }
}