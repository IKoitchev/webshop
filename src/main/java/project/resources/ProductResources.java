package project.resources;

import project.model.Product;
import project.repository.FakeDataStore;

import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.QueryParam;
import javax.ws.rs.core.*;
import java.util.List;

@Path("/products")

public class ProductResources {

    FakeDataStore fakeDataStore = new FakeDataStore();
    @Context
    private UriInfo uriInfo;
   // private static final FakeDataStore fakeDataStore = new FakeDataStore();

    @GET
    @Path("/home")
    @Produces(MediaType.APPLICATION_JSON)
    public Response showProducts() {
        List<Product> products = fakeDataStore.getProductList();
        GenericEntity<List<Product>> entity = new GenericEntity<>(products) {  };
        return Response.ok(entity).build();
    }





    @GET
    @Produces(MediaType.APPLICATION_JSON)
    public Response getProductByName(@QueryParam("name") String name) {
        Product product;
        if (uriInfo.getQueryParameters().containsKey("name")){
            return Response.ok(fakeDataStore.getProductByName(name)).build();
        }
        else{
            return Response.status(Response.Status.BAD_REQUEST).entity("Invalid name.").build();
        }
    }



}
