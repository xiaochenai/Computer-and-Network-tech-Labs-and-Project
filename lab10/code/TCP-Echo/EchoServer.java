import java.net.*;
import java.io.*; 
  	ServerSocket serverSocket = null;
	catch (IOException e) {
	Socket clientSocket = null;
	catch (IOException e) {
	PrintWriter out = new PrintWriter(clientSocket.getOutputStream(), true);
	while ((inputLine = in.readLine()) != null) {	
    	System.out.println("Echo to TCP Client: " + outputLine);
	out.close();