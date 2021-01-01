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
import org.springframework.http.ResponseEntity;
import org.springframework.test.context.junit4.SpringRunner;
import org.springframework.web.client.RestTemplate;

import javax.print.URIException;

import java.net.URI;
import java.net.URISyntaxException;

import static org.junit.jupiter.api.Assertions.*;

@RunWith(SpringRunner.class)
@SpringBootTest(webEnvironment = SpringBootTest.WebEnvironment.RANDOM_PORT)
class ProductResourcesTest {

    @LocalServerPort
    int randomSeverPort;

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
        String productName = "testProduct";
        double productPrice = 15.0;

        final String baseURI = "http://localhost:" + randomSeverPort + "/products/post?name=" + productName +"&price="+productPrice;
        URI uri = new URI(baseURI);

        ResponseEntity<String> result = restTemplate.getForEntity(uri, String.class);

        
    }

    @Test
    void testUpdateProductDescription() {
    }

    @Test
    void testDeleteProductById() {
    }
}