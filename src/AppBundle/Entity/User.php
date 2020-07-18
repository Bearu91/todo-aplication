<?php
     namespace AppBundle\Entity;

        use FOS\UserBundle\Model\User as BaseUser;
        use Doctrine\ORM\Mapping as ORM;
        use JMS\Serializer\Annotation as JMS;
        /**
         * @ORM\Entity
         * @ORM\Table(name="fos_user")
         * @JMS\ExclusionPolicy("all")
         */
        class User extends BaseUser
        {
            /**
             * @ORM\Id
             * @ORM\Column(type="integer")
             * @JMS\Expose();
             * @ORM\GeneratedValue(strategy="AUTO")
             */
            protected $id;

            public function __construct()
            {
                parent::__construct();
                // your own logic
            }
        }
