import java.net.*;
import java.io.*; 
public class MultiEchoServerThread extends Thread {
	private Socket clientSocket = null;	

	public MultiEchoServerThread(Socket clientSocket) {
  
	public void run(){
			PrintWriter out = new PrintWriter(clientSocket.getOutputStream(), true);
    			System.out.println("TCP Port Number: " + clientSocket.getPort());
    			System.out.println("Echo to TCP Client: " + outputLine);
		out.close();
        } 
        	catch (IOException e) {
    } 