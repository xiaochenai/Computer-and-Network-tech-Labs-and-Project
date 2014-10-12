import java.net.*;
import java.io.*; public class EchoServer { 
	public static void main(String[] args) throws IOException { 
	  	DatagramSocket serverSocket = null;		try {		    serverSocket = new DatagramSocket(2000);		} catch (IOException e) {		    System.out.println("Could not listen on port: 2000" + e);		    System.exit(-1);		} 
	    byte[] inData = new byte[1400]; 	    byte[] outData  = new byte[1400];
	    int inPacketLength; 
	    String inputLine;
		while (true) {
			DatagramPacket inPacket = new DatagramPacket(inData, inData.length);
			serverSocket.receive(inPacket); 
		    System.out.println("inData length " + inData.length);
			inPacketLength = inPacket.getLength();
			System.out.println("inPacket length: " + inPacketLength);		    inputLine = new String(inPacket.getData(), 0, inPacketLength);
		    System.out.println("inputLine length " + inputLine.length());
		    InetAddress clientIPAddress = inPacket.getAddress(); 			int port = inPacket.getPort();		    outData = inputLine.getBytes();		    DatagramPacket outPacket = new DatagramPacket(outData, outData.length, clientIPAddress, port); 			serverSocket.send(outPacket); 		    System.out.println("Echo to UDP Client: " + inputLine);		    if (inputLine.equals("Bye."))		        break;        		}
    	serverSocket.close(); 
    } } 