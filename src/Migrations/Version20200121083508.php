<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200121083508 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql("
            INSERT INTO department (code, name) VALUES ('01', 'Ain');
            INSERT INTO department (code, name) VALUES ('02', 'Aisne');
            INSERT INTO department (code, name) VALUES ('03', 'Allier');
            INSERT INTO department (code, name) VALUES ('04', 'Alpes-de-Haute-Provence');
            INSERT INTO department (code, name) VALUES ('05', 'Hautes-Alpes');
            INSERT INTO department (code, name) VALUES ('06', 'Alpes-Maritimes');
            INSERT INTO department (code, name) VALUES ('07', 'Ardèche');
            INSERT INTO department (code, name) VALUES ('08', 'Ardennes');
            INSERT INTO department (code, name) VALUES ('09', 'Ariège');
            INSERT INTO department (code, name) VALUES ('10', 'Aube');
            INSERT INTO department (code, name) VALUES ('11', 'Aude');
            INSERT INTO department (code, name) VALUES ('12', 'Aveyron');
            INSERT INTO department (code, name) VALUES ('13', 'Bouches-du-Rhône');
            INSERT INTO department (code, name) VALUES ('14', 'Calvados');
            INSERT INTO department (code, name) VALUES ('15', 'Cantal');
            INSERT INTO department (code, name) VALUES ('16', 'Charente');
            INSERT INTO department (code, name) VALUES ('17', 'Charente-Maritime');
            INSERT INTO department (code, name) VALUES ('18', 'Cher');
            INSERT INTO department (code, name) VALUES ('19', 'Corrèze');
            INSERT INTO department (code, name) VALUES ('21', 'Côte-d\'Or');
            INSERT INTO department (code, name) VALUES ('22', 'Côtes-d\'Armor');
            INSERT INTO department (code, name) VALUES ('23', 'Creuse');
            INSERT INTO department (code, name) VALUES ('24', 'Dordogne');
            INSERT INTO department (code, name) VALUES ('25', 'Doubs');
            INSERT INTO department (code, name) VALUES ('26', 'Drôme');
            INSERT INTO department (code, name) VALUES ('27', 'Eure');
            INSERT INTO department (code, name) VALUES ('28', 'Eure-et-Loir');
            INSERT INTO department (code, name) VALUES ('29', 'Finistère');
            INSERT INTO department (code, name) VALUES ('02A', 'Corse-du-Sud');
            INSERT INTO department (code, name) VALUES ('02B', 'Haute-Corse');
            INSERT INTO department (code, name) VALUES ('30', 'Gard');
            INSERT INTO department (code, name) VALUES ('31', 'Haute-Garonne');
            INSERT INTO department (code, name) VALUES ('32', 'Gers');
            INSERT INTO department (code, name) VALUES ('33', 'Gironde');
            INSERT INTO department (code, name) VALUES ('34', 'Hérault');
            INSERT INTO department (code, name) VALUES ('35', 'Ille-et-Vilaine');
            INSERT INTO department (code, name) VALUES ('36', 'Indre');
            INSERT INTO department (code, name) VALUES ('37', 'Indre-et-Loire');
            INSERT INTO department (code, name) VALUES ('38', 'Isère');
            INSERT INTO department (code, name) VALUES ('39', 'Jura');
            INSERT INTO department (code, name) VALUES ('40', 'Landes');
            INSERT INTO department (code, name) VALUES ('41', 'Loir-et-Cher');
            INSERT INTO department (code, name) VALUES ('42', 'Loire');
            INSERT INTO department (code, name) VALUES ('43', 'Haute-Loire');
            INSERT INTO department (code, name) VALUES ('44', 'Loire-Atlantique');
            INSERT INTO department (code, name) VALUES ('45', 'Loiret');
            INSERT INTO department (code, name) VALUES ('46', 'Lot');
            INSERT INTO department (code, name) VALUES ('47', 'Lot-et-Garonne');
            INSERT INTO department (code, name) VALUES ('48', 'Lozère');
            INSERT INTO department (code, name) VALUES ('49', 'Maine-et-Loire');
            INSERT INTO department (code, name) VALUES ('50', 'Manche');
            INSERT INTO department (code, name) VALUES ('51', 'Marne');
            INSERT INTO department (code, name) VALUES ('52', 'Haute-Marne');
            INSERT INTO department (code, name) VALUES ('53', 'Mayenne');
            INSERT INTO department (code, name) VALUES ('54', 'Meurthe-et-Moselle');
            INSERT INTO department (code, name) VALUES ('55', 'Meuse');
            INSERT INTO department (code, name) VALUES ('56', 'Morbihan');
            INSERT INTO department (code, name) VALUES ('57', 'Moselle');
            INSERT INTO department (code, name) VALUES ('58', 'Nièvre');
            INSERT INTO department (code, name) VALUES ('59', 'Nord');
            INSERT INTO department (code, name) VALUES ('60', 'Oise');
            INSERT INTO department (code, name) VALUES ('61', 'Orne');
            INSERT INTO department (code, name) VALUES ('62', 'Pas-de-Calais');
            INSERT INTO department (code, name) VALUES ('63', 'Puy-de-Dôme');
            INSERT INTO department (code, name) VALUES ('64', 'Pyrénées-Atlantiques');
            INSERT INTO department (code, name) VALUES ('65', 'Hautes-Pyrénées');
            INSERT INTO department (code, name) VALUES ('66', 'Pyrénées-Orientales');
            INSERT INTO department (code, name) VALUES ('67', 'Bas-Rhin');
            INSERT INTO department (code, name) VALUES ('68', 'Haut-Rhin');
            INSERT INTO department (code, name) VALUES ('69', 'Rhône');
            INSERT INTO department (code, name) VALUES ('70', 'Haute-Saône');
            INSERT INTO department (code, name) VALUES ('71', 'Saône-et-Loire');
            INSERT INTO department (code, name) VALUES ('72', 'Sarthe');
            INSERT INTO department (code, name) VALUES ('73', 'Savoie');
            INSERT INTO department (code, name) VALUES ('74', 'Haute-Savoie');
            INSERT INTO department (code, name) VALUES ('75', 'Paris');
            INSERT INTO department (code, name) VALUES ('76', 'Seine-Maritime');
            INSERT INTO department (code, name) VALUES ('77', 'Seine-et-Marne');
            INSERT INTO department (code, name) VALUES ('78', 'Yvelines');
            INSERT INTO department (code, name) VALUES ('79', 'Deux-Sèvres');
            INSERT INTO department (code, name) VALUES ('80', 'Somme');
            INSERT INTO department (code, name) VALUES ('81', 'Tarn');
            INSERT INTO department (code, name) VALUES ('82', 'Tarn-et-Garonne');
            INSERT INTO department (code, name) VALUES ('83', 'Var');
            INSERT INTO department (code, name) VALUES ('84', 'Vaucluse');
            INSERT INTO department (code, name) VALUES ('85', 'Vendée');
            INSERT INTO department (code, name) VALUES ('86', 'Vienne');
            INSERT INTO department (code, name) VALUES ('87', 'Haute-Vienne');
            INSERT INTO department (code, name) VALUES ('88', 'Vosges');
            INSERT INTO department (code, name) VALUES ('89', 'Yonne');
            INSERT INTO department (code, name) VALUES ('90', 'Territoire de Belfort');
            INSERT INTO department (code, name) VALUES ('91', 'Essonne');
            INSERT INTO department (code, name) VALUES ('92', 'Hauts-de-Seine');
            INSERT INTO department (code, name) VALUES ('93', 'Seine-Saint-Denis');
            INSERT INTO department (code, name) VALUES ('94', 'Val-de-Marne');
            INSERT INTO department (code, name) VALUES ('95', 'Val-d\'Oise');
            INSERT INTO department (code, name) VALUES ('971', 'Guadeloupe');
            INSERT INTO department (code, name) VALUES ('972', 'Martinique');
            INSERT INTO department (code, name) VALUES ('973', 'Guyane');
            INSERT INTO department (code, name) VALUES ('974', 'La Réunion');
            INSERT INTO department (code, name) VALUES ('976', 'Mayotte');
        ");

        $this->addSql("
            INSERT INTO duty (name) VALUES ('Hôte');
            INSERT INTO duty (name) VALUES ('Vendeur');
        ");

        $this->addSql("
            INSERT INTO question_category (category) VALUES ('Général');
            INSERT INTO question_category (category) VALUES ('Fonctionnement du site');
            INSERT INTO question_category (category) VALUES ('Les différents onglets du site');
        ");

        $this->addSql("INSERT INTO subscription (one_month, six_month, one_year) VALUES ('15', '10', '8');");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE department');
        $this->addSql('TRUNCATE TABLE duty');
        $this->addSql('TRUNCATE TABLE question_category');
        $this->addSql('TRUNCATE TABLE subscription');
    }
}
