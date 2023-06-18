<?php

namespace App\Entity;

use App\Repository\SupportTicketRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SupportTicketRepository::class)]

#[UniqueEntity("ticket_message")]
class SupportTicket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom_support = null;

    #[ORM\Column(length: 50)]
    private ?string $nom_demandeur = null;

    #[ORM\Column(length: 10000)]
    private ?string $ticket_message = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_creation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_resolution = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSupport(): ?string
    {
        return $this->nom_support;
    }

    public function setNomSupport(string $nom_support): static
    {
        $this->nom_support = $nom_support;

        return $this;
    }

    public function getNomDemandeur(): ?string
    {
        return $this->nom_demandeur;
    }

    public function setNomDemandeur(string $nom_demandeur): static
    {
        $this->nom_demandeur = $nom_demandeur;

        return $this;
    }

    public function getTicketMessage(): ?string
    {
        return $this->ticket_message;
    }

    public function setTicketMessage(string $ticket_message): static
    {
        $this->ticket_message = $ticket_message;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): static
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDateResolution(): ?\DateTimeInterface
    {
        return $this->date_resolution;
    }

    public function setDateResolution(\DateTimeInterface $date_resolution): static
    {
        $this->date_resolution = $date_resolution;

        return $this;
    }
}
