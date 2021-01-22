package com.example.webshop.resources;

import com.example.webshop.model.Product;
import com.example.webshop.repository.ProductRepository;
import org.apache.coyote.Response;
import org.junit.Assert;
import org.junit.jupiter.api.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.context.SpringBootTest;
import org.springframework.boot.web.server.LocalServerPort;
import org.springframework.http.*;
import org.springframework.test.context.junit4.SpringRunner;
import org.springframework.util.LinkedMultiValueMap;
import org.springframework.util.MultiValueMap;
import org.springframework.web.client.RestTemplate;

import javax.print.URIException;

import java.net.URI;
import java.net.URISyntaxException;
import java.util.HashMap;
import java.util.Map;

import static org.junit.jupiter.api.Assertions.*;

@RunWith(SpringRunner.class)
@SpringBootTest(webEnvironment = SpringBootTest.WebEnvironment.RANDOM_PORT)
class ProductResourcesTest {

    @LocalServerPort
    int randomSeverPort;

    @Autowired
    ProductRepository productRepository;

    public Product getTestProduct(){
        Product product = new Product();
        product.setName("testProduct");
        product.setPrice(15);
        product.setDescription("testingProduct");
        product.setGenre("genre");
        return product;
    }

    @Test
    void testGetAllProducts() throws URISyntaxException {
        RestTemplate restTemplate = new RestTemplate();

        final String baseURI = "http://localhost:" + randomSeverPort + "/products/all";
        URI uri = new URI(baseURI);

        ResponseEntity<String> result = restTemplate.getForEntity(uri, String.class);

        Assert.assertEquals(200, result.getStatusCodeValue());
        Assert.assertEquals(true, result.getBody().contains("id"));
        Assert.assertEquals(true, result.getBody().contains("name"));
        Assert.assertEquals(true, result.getBody().contains("description"));
        Assert.assertEquals(true, result.getBody().contains("price"));
    }

    @Test
    void testGetProductByName() throws URISyntaxException{

        RestTemplate restTemplate = new RestTemplate();
        String productName = "amongus";

        final String baseURI = "http://localhost:" + randomSeverPort + "/products/get?name=" + productName;
        URI uri = new URI(baseURI);

        ResponseEntity<String> result = restTemplate.getForEntity(uri, String.class);

        Assert.assertEquals(200, result.getStatusCodeValue());


    }

    @Test
    void testAddProduct() throws URISyntaxException{
        RestTemplate restTemplate = new RestTemplate();
        Product product = getTestProduct();

        final String baseURI = "http://localhost:" + randomSeverPort + "/products/post";
        URI uri = new URI(baseURI);

        HttpHeaders httpHeaders = new HttpHeaders();
        httpHeaders.setContentType(MediaType.APPLICATION_JSON);
        HttpEntity<Product> request = new HttpEntity<>(product, httpHeaders);
        ResponseEntity<String> result = restTemplate.postForEntity(uri, request, String.class);

        Assert.assertEquals(200, result.getStatusCodeValue());

        productRepository.deleteById(productRepository.findByName("testProduct").getId()); // Delete the product afterwards
    }

    @Test
    void testUpdateProduct() throws URISyntaxException{
        RestTemplate restTemplate = new RestTemplate();

        productRepository.save(getTestProduct());
        Product product = productRepository.findByName("testProduct");
        product.setName("testProduct - updated");
        product.setPrice(15);
        product.setDescription("testingProduct - updated");
        product.setGenre("genre");

        final String baseURI = "http://localhost:" + randomSeverPort + "/products/update";
         URI uri = new URI(baseURI);

        HttpHeaders httpHeaders = new HttpHeaders();
        httpHeaders.setContentType(MediaType.APPLICATION_JSON);
        HttpEntity<Product> request = new HttpEntity<>(product, httpHeaders);
        ResponseEntity<String> result = restTemplate.exchange(uri, HttpMethod.PUT, request, String.class);


        Assert.assertEquals(200, result.getStatusCodeValue());

        productRepository.deleteById(productRepository.findByName("testProduct").getId());
    }

    @Test
    void testDeleteProductById() throws URISyntaxException{
        RestTemplate restTemplate = new RestTemplate();

        productRepository.save(getTestProduct());
        Product product = productRepository.findByName("testProduct");

        final String baseURI = "http://localhost:" + randomSeverPort + "/products/delete?id=" + product.getId();
        URI uri = new URI(baseURI);

        ResponseEntity<String> result = restTemplate.exchange(uri, HttpMethod.DELETE, null, String.class);

        Assert.assertEquals(200, result.getStatusCodeValue());
    }
}