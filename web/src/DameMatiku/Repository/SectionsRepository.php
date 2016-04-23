<?php

namespace DameMatiku\Repository;

use Doctrine\DBAL\Connection;
use DameMatiku\Entity\Section;

/**
 * Section repository
 */
class SectionsRepository extends BaseRepository
{
    protected $table = "section";

    /** @var DameMatiku\Repository\ChaptersRepository */
    protected $subjectsRepository;

    /** @var DameMatiku\Repository\ChaptersRepository */
    protected $chaptersRepository;

    public function __construct(Connection $db, $subjectsRepository, $chaptersRepository)
    {
        $this->db = $db;
        $this->subjectsRepository = $subjectsRepository;
        $this->chaptersRepository = $chaptersRepository;
    }

    /**
     * Instantiates a section entity and sets its properties using db data.
     * @param array $data
     *   The array of db data.
     * @return DameMatiku\Entity\Section
     */
    protected function build($data)
    {
        $subject = $this->subjectsRepository->find($data['subject_id']);
        $chapters = $this->chaptersRepository->findAllBySectionId($data['id']);

        $section = new Section();
        $section->setId($data['id']);
        $section->setName($data['name']);
        $section->setSequence($data['sequence']);
        $section->setSubject($subject);
        $section->setChapters($chapters);
        return $section;
    }

    public function findAllBySubjectId($subjectId) {
        return $this->findAll([ 'subject_id' => $subjectId ], [ 'sequence' => 'ASC']);
    }
}