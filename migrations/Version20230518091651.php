<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230518091651 extends AbstractMigration {

	public function getDescription(): string {
		return 'Create base services table';
	}

	public function up(Schema $schema): void {
		$this->addSql('CREATE SEQUENCE abstract_service_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
		$this->addSql('CREATE SEQUENCE mumble_server_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
		$this->addSql('CREATE SEQUENCE server_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
		$this->addSql('CREATE SEQUENCE service_region_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
		$this->addSql('CREATE TABLE abstract_service (id INT NOT NULL, server_id INT DEFAULT NULL, internal_service_name VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
		$this->addSql('CREATE INDEX IDX_432AFC421844E6B7 ON abstract_service (server_id)');
		$this->addSql('CREATE TABLE mumble_server (id INT NOT NULL, channel_count INT NOT NULL, PRIMARY KEY(id))');
		$this->addSql('CREATE TABLE mumble_service (id INT NOT NULL, channel_counts INT NOT NULL, PRIMARY KEY(id))');
		$this->addSql('CREATE TABLE server (id INT NOT NULL, region_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
		$this->addSql('CREATE INDEX IDX_5A6DD5F698260155 ON server (region_id)');
		$this->addSql('CREATE TABLE service_region (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
		$this->addSql('CREATE TABLE wireguard_service (id INT NOT NULL, ipv4 VARCHAR(255) DEFAULT NULL, ipv6 VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
		$this->addSql('ALTER TABLE abstract_service ADD CONSTRAINT FK_432AFC421844E6B7 FOREIGN KEY (server_id) REFERENCES server (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE mumble_service ADD CONSTRAINT FK_DEDA8FEEBF396750 FOREIGN KEY (id) REFERENCES abstract_service (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE server ADD CONSTRAINT FK_5A6DD5F698260155 FOREIGN KEY (region_id) REFERENCES service_region (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE wireguard_service ADD CONSTRAINT FK_92A00874BF396750 FOREIGN KEY (id) REFERENCES abstract_service (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
	}

	public function down(Schema $schema): void {
		$this->addSql('CREATE SCHEMA public');
		$this->addSql('DROP SEQUENCE abstract_service_id_seq CASCADE');
		$this->addSql('DROP SEQUENCE mumble_server_id_seq CASCADE');
		$this->addSql('DROP SEQUENCE server_id_seq CASCADE');
		$this->addSql('DROP SEQUENCE service_region_id_seq CASCADE');
		$this->addSql('ALTER TABLE abstract_service DROP CONSTRAINT FK_432AFC421844E6B7');
		$this->addSql('ALTER TABLE mumble_service DROP CONSTRAINT FK_DEDA8FEEBF396750');
		$this->addSql('ALTER TABLE server DROP CONSTRAINT FK_5A6DD5F698260155');
		$this->addSql('ALTER TABLE wireguard_service DROP CONSTRAINT FK_92A00874BF396750');
		$this->addSql('DROP TABLE abstract_service');
		$this->addSql('DROP TABLE mumble_server');
		$this->addSql('DROP TABLE mumble_service');
		$this->addSql('DROP TABLE server');
		$this->addSql('DROP TABLE service_region');
		$this->addSql('DROP TABLE wireguard_service');
	}

}
