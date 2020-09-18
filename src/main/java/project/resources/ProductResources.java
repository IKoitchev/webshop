package project.resources;

import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.core.Context;
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;
import javax.ws.rs.core.UriInfo;

@Path("/products")

public class ProductResources {

    @Context
    private UriInfo uriInfo;
   // private static final FakeDataStore fakeDataStore = new FakeDataStore();

    @GET
    @Path("/home")
    @Produces(MediaType.TEXT_PLAIN)
    public Response showProducts() {
        String msg = " products page here";
        return Response.ok(msg).build();
    }


}
