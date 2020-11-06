package com.example.webshop.resources;

import com.example.webshop.model.Product;
import com.example.webshop.repository.ProductRepository;
import com.fasterxml.jackson.annotation.JsonFormat;
import org.apache.catalina.connector.Response;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.ArrayList;
import java.util.List;
import java.util.Optional;


@RestController
@RequestMapping(value = "/products")
public class ProductResources {

    @Autowired
    ProductRepository productRepository;

    @GetMapping(value = "/all")
    public List<Product> getAllProducts() {
        return (List<Product>) productRepository.findAll();
    }

    @GetMapping(value = "/get")
    public Product getProductByName(@RequestParam String name ){

        return productRepository.findByName(name);

    }

    @PostMapping(value = "/post")
    public Product addProduct(@RequestParam String name, double price){
        Product product = new Product();
        product.setName(name);
        product.setPrice(price);
        product.setDescription("no description");
        productRepository.save(product);
        return product;
    }
    @PutMapping(value = "/update")
    public Product updateProductDescription(@RequestParam String description, String name){
        Product product = productRepository.findByName(name);
        product.setDescription(description);
        productRepository.save(product);
        return product;
    }
    @DeleteMapping(value = "/delete")
    public void deleteProductById(@RequestParam long id){
        productRepository.deleteById(id);

    }


}
