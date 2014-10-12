import java.io.BufferedReader;
import java.io.FileOutputStream;
import java.io.FileReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.DatagramPacket;
import java.net.DatagramSocket;
import java.net.InetAddress;
import java.security.KeyFactory;
import java.security.PublicKey;
import java.security.SecureRandom;
import java.security.spec.EncodedKeySpec;
import java.security.spec.X509EncodedKeySpec;

import javax.crypto.Cipher;
import javax.crypto.KeyGenerator;
import javax.crypto.SecretKey;





public class client {
	private static int Serverport;
	private static DatagramSocket socket;
	private static InetAddress ServerIpAddress;

	public static void main(String[] args) throws IOException { 	
		BufferedReader stdIn = new BufferedReader(new InputStreamReader(System.in)); 
		DatagramSocket echoSocket = new DatagramSocket(); 
	    InetAddress serverIPAddress = InetAddress.getByName("192.168.0.2");
	    byte[] outData = new byte[1400]; 
	    byte[] inData = new byte[1400];   
		String userInput;
		int inPacketLength;
		while ((userInput = stdIn.readLine()) != null) { 
			outData = userInput.getBytes(); 
		  	DatagramPacket outPacket = new DatagramPacket(outData, outData.length, serverIPAddress, 2000); 
			echoSocket.send(outPacket);
			System.out.println("OutData length:" + outData.length);
			DatagramPacket inPacket = new DatagramPacket(inData, inData.length); 
	  		echoSocket.receive(inPacket);
	  		inPacketLength = inPacket.getLength(); 
	  		String echoString = new String(inPacket.getData(), 0, inPacketLength); 
	  		System.out.println("Echo from UDP Server: " + echoString); 
			System.out.println("inPacket length:" + inPacketLength);
	    	if (userInput.equals("Bye."))
	        	break;        
		 } 	
		stdIn.close(); 
		echoSocket.close(); 
	}
}
