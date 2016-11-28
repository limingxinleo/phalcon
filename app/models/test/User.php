<?php

namespace MyApp\Models\Test;

use Phalcon\Mvc\Model\Validator\Email as Email;

class User extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    public $id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $username;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $password;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $email;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $role_id;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $created_at;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $updated_at;

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        return true;
    }


    public function beforeCreate()
    {
        // Set the creation date
        $this->created_at = date("Y-m-d H:i:s");
        $this->updated_at = date("Y-m-d H:i:s");
    }


    public function beforeUpdate()
    {
        // Set the modification date
        $this->updated_at = date("Y-m-d H:i:s");
    }


    public function initialize()
    {
        $this->hasMany('id', 'MyApp\\Models\\Test\\Book', 'uid', ['alias' => 'book']);
        $this->hasManyToMany(
            'id',
            'MyApp\\Models\\Test\\UserTitle', 'uid', 'title_id',
            'MyApp\\Models\\Test\\Title', 'id',
            ['alias' => 'title']
        );
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return User[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return User
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }

}
