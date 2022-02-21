<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221151639 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_lang (project_id INT NOT NULL, lang_id INT NOT NULL, INDEX IDX_8984C7A166D1F9C (project_id), INDEX IDX_8984C7AB213FA4 (lang_id), PRIMARY KEY(project_id, lang_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_lang (user_id INT NOT NULL, lang_id INT NOT NULL, INDEX IDX_4B88C8ABA76ED395 (user_id), INDEX IDX_4B88C8ABB213FA4 (lang_id), PRIMARY KEY(user_id, lang_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project_lang ADD CONSTRAINT FK_8984C7A166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_lang ADD CONSTRAINT FK_8984C7AB213FA4 FOREIGN KEY (lang_id) REFERENCES lang (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_lang ADD CONSTRAINT FK_4B88C8ABA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_lang ADD CONSTRAINT FK_4B88C8ABB213FA4 FOREIGN KEY (lang_id) REFERENCES lang (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project ADD user_id INT NOT NULL, ADD lang_id INT NOT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEB213FA4 FOREIGN KEY (lang_id) REFERENCES lang (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEA76ED395 ON project (user_id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEB213FA4 ON project (lang_id)');
        $this->addSql('ALTER TABLE traduction_source ADD project_id INT NOT NULL');
        $this->addSql('ALTER TABLE traduction_source ADD CONSTRAINT FK_E51D494166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('CREATE INDEX IDX_E51D494166D1F9C ON traduction_source (project_id)');
        $this->addSql('ALTER TABLE traduction_target ADD traduction_source_id INT NOT NULL, ADD lang_id INT NOT NULL');
        $this->addSql('ALTER TABLE traduction_target ADD CONSTRAINT FK_17B4841B6563B46B FOREIGN KEY (traduction_source_id) REFERENCES traduction_source (id)');
        $this->addSql('ALTER TABLE traduction_target ADD CONSTRAINT FK_17B4841BB213FA4 FOREIGN KEY (lang_id) REFERENCES lang (id)');
        $this->addSql('CREATE INDEX IDX_17B4841B6563B46B ON traduction_target (traduction_source_id)');
        $this->addSql('CREATE INDEX IDX_17B4841BB213FA4 ON traduction_target (lang_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE project_lang');
        $this->addSql('DROP TABLE user_lang');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEA76ED395');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEB213FA4');
        $this->addSql('DROP INDEX IDX_2FB3D0EEA76ED395 ON project');
        $this->addSql('DROP INDEX IDX_2FB3D0EEB213FA4 ON project');
        $this->addSql('ALTER TABLE project DROP user_id, DROP lang_id');
        $this->addSql('ALTER TABLE traduction_source DROP FOREIGN KEY FK_E51D494166D1F9C');
        $this->addSql('DROP INDEX IDX_E51D494166D1F9C ON traduction_source');
        $this->addSql('ALTER TABLE traduction_source DROP project_id');
        $this->addSql('ALTER TABLE traduction_target DROP FOREIGN KEY FK_17B4841B6563B46B');
        $this->addSql('ALTER TABLE traduction_target DROP FOREIGN KEY FK_17B4841BB213FA4');
        $this->addSql('DROP INDEX IDX_17B4841B6563B46B ON traduction_target');
        $this->addSql('DROP INDEX IDX_17B4841BB213FA4 ON traduction_target');
        $this->addSql('ALTER TABLE traduction_target DROP traduction_source_id, DROP lang_id');
    }
}
