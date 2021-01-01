package com.example.webshop.resources;

import org.springframework.core.io.ByteArrayResource;
import org.springframework.core.io.Resource;
import org.springframework.http.HttpHeaders;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import java.io.File;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.function.Consumer;

@RestController
@RequestMapping(value = "/images")
public class PictureResources {

    @GetMapping(value="/{param}")
    public ResponseEntity<Resource> download(@PathVariable("param") String param) throws IOException{

        File file = new File("images/" + param);
        Path path = Paths.get(file.getAbsolutePath());
        System.out.println(path);
        ByteArrayResource resource = new ByteArrayResource(Files.readAllBytes(path));

        return ResponseEntity.ok()
                .headers(new HttpHeaders())
                .contentLength((file.length()))
                .contentType(MediaType.APPLICATION_OCTET_STREAM)
                .body(resource);
    }
}
