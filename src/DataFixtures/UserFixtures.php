<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\DepartmentBranch;
use App\Entity\Region;
use App\Entity\User;
use App\Entity\UserDetail;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Firebase\JWT\JWT;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {

        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        //  php bin/console doctrine:fixtures:load
        $userTypes = ['ROLE_CUSTOMER', 'ROLE_USER', 'ROLE_ADMIN', 'ROLE_SUPERADMIN'];
        $userNames = [
            'TANER AKDEMİR',
            'SUNA ŞENGÜL',
            'ALPTUNGA UREY',
            'SERAP ASLAN',
            'İZEL ARIKAN',
            'MURAT BAYKAL',
            'ÜNSAL BATUKER',
            'SEFA KOCAAĞA',
            'BERK EREN',
            'EYÜP TUĞRUL',
            'ŞENOL YAYA'
        ];
        $userMails = [
            'akdemirt@turcom.com.tr',
            'senguls@turcom.com.tr',
            'ureya@turcom.com.tr',
            'aslans@turcom.com.tr',
            'arikani@turcom.com.tr',
            'baykalm@turcom.com.tr',
            'batukera@turcom.com.tr',
            'kocaagas@turcom.com.tr',
            'erenb@turcom.com.tr',
            'tugrule@turcom.com.tr',
            'yayas@turcom.com.tr',
            'uzunlarn@turcom.com.tr'
        ];

        $userTitles = [
            'YAZILIM VE AR-GE MÜDÜRÜ',
            'CALL CENTER YÖNETİCİSİ',
            '.NET YAZILIM UZMANI',
            '.NET YAZILIM UZMAN YARDIMCISI',
            'AR-GE UZMANI',
            'FRONTEND YAZILIM UZMANI',
            'TEKNİK EKİPLER DİREKTÖRÜ',
            'MOBİL UYGULAMA UZMANI',
            'PYTHON YAZILIM UZMANI',
            'PYTHON YAZILIM UZMANI',
            'PHP YAZILIM UZMANI',
            'NETWORK YÖNETİCİSİ'
        ];

        $userDepartmentBranch = [
            2,
            4,
            2,
            2,
            2,
            2,
            12,
            2,
            2,
            2,
            5,
            1
        ];
        $userRegion = [
            34,
            34,
            34,
            34,
            34,
            34,
            34,
            34,
            34,
            34,
            34,
            34
        ];

        $jwtKey = $_ENV['JWT_KEY'];
        $randomIndex = random_int(0, (count($userNames) - 1));

        for ($i = 0, $iMax = count($userNames); $i < $iMax; $i++) {

            $companyRepository = $manager->getRepository(Company::class);
            $regionRepository = $manager->getRepository(Region::class);
            $departmentBranchRepository = $manager->getRepository(DepartmentBranch::class);

            $name = $userNames[$i];
            $userName = $userMails[$i];
            $payLoad = ['email' => $userName];
            $password = '123';
            $user = new User();
            $user->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
            $user->setEmail($userName);
            $user->setName(mb_strtoupper($name));
            $user->setJwtToken(JWT::encode($payLoad, $jwtKey));
            $user->setPassword($this->userPasswordEncoder->encodePassword($user, $password));
            $user->setRoles([$userTypes[random_int(0, (count($userTypes) - 1))]]);
            $user->setMobilePhone('05303200647');
            $user->setIsVIP(false);
            $manager->persist($user);
            $manager->flush();
            if($user->getId()){
                $userDetail = new UserDetail();
                $userDetail->setCompany($companyRepository->find(1));
                $userDetail->setUser($user);
                $userDetail->setDepartmentBranch($departmentBranchRepository->find($userDepartmentBranch[$i]));
                $userDetail->setRegion($regionRepository->find($userRegion[$i]));
                $userDetail->setTitle($userTitles[$i]);
                $manager->persist($userDetail);
                $manager->flush();
            }
        }


    }

    public static function getGroups(): array
    {
        return ['user'];
    }
}
