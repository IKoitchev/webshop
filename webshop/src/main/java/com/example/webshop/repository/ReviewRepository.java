package com.example.webshop.repository;

import com.example.webshop.model.Review;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.rest.core.annotation.RepositoryRestResource;

import java.util.List;
import java.util.Optional;

@RepositoryRestResource
public interface ReviewRepository extends JpaRepository<Review, Long> {

    List<Review> findAll ();
}