package com.example.webshop.repository;

import com.example.webshop.model.Product;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.repository.CrudRepository;
import org.springframework.data.rest.core.annotation.RepositoryRestResource;

import java.util.Optional;

@RepositoryRestResource
public interface ProductRepository extends JpaRepository<Product, Long> {

    Product findByNameContaining(String name);


    Product findByName(String name);
}
