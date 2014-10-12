import java.net.*;
import java.io.*; 
	public static void main(String[] args) throws IOException { 
	  	DatagramSocket serverSocket = null;
	    byte[] inData = new byte[1400]; 
	    int inPacketLength; 
	    String inputLine;
		while (true) {
			DatagramPacket inPacket = new DatagramPacket(inData, inData.length);
			serverSocket.receive(inPacket); 
		    System.out.println("inData length " + inData.length);
			inPacketLength = inPacket.getLength();
			System.out.println("inPacket length: " + inPacketLength);
		    System.out.println("inputLine length " + inputLine.length());
		    InetAddress clientIPAddress = inPacket.getAddress(); 
    	serverSocket.close(); 
    } 