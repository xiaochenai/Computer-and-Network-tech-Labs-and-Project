

import java.net.*;
import java.security.InvalidKeyException;
import java.security.KeyFactory;
import java.security.NoSuchAlgorithmException;
import java.security.PrivateKey;
import java.security.SecureRandom;
import java.security.spec.EncodedKeySpec;
import java.security.spec.InvalidKeySpecException;
import java.security.spec.PKCS8EncodedKeySpec;

import java.io.*;

import javax.crypto.BadPaddingException;
import javax.crypto.Cipher;
import javax.crypto.IllegalBlockSizeException;
import javax.crypto.KeyGenerator;
import javax.crypto.NoSuchPaddingException;
import javax.crypto.SecretKey;

import biz.source_code.base64Coder.Base64Coder;

public class MultiUserServerThread extends Thread
{	
	
	private DatagramSocket socket = null;


	public MultiUserServerThread( DatagramSocket socket )
	{
		this.socket = socket;
	}

	public void run()
	{
		while(true)
		{
		//attention: the receive buffer is just 1024byte, so can not handle data bigger than 1024 bytes
		
	  	DatagramSocket serverSocket = null;
		try {
		    serverSocket = new DatagramSocket(2000);
		} catch (IOException e) {
		    System.out.println("Could not listen on port: 2000" + e);
		    System.exit(-1);
		} 
	    byte[] inData = new byte[1400]; 
	    byte[] outData  = new byte[1400];
	    int inPacketLength; 
	    String inputLine;
		while (true) {
			DatagramPacket inPacket = new DatagramPacket(inData, inData.length);
			try {
				serverSocket.receive(inPacket);
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} 
		    System.out.println("inData length " + inData.length);
			inPacketLength = inPacket.getLength();
			System.out.println("inPacket length: " + inPacketLength);
		    inputLine = new String(inPacket.getData(), 0, inPacketLength);
		    System.out.println("inputLine length " + inputLine.length());
		    InetAddress clientIPAddress = inPacket.getAddress(); 
			int port = inPacket.getPort();
		    outData = inputLine.getBytes();
		    DatagramPacket outPacket = new DatagramPacket(outData, outData.length, clientIPAddress, port); 
			try {
				serverSocket.send(outPacket);
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} 
		    System.out.println("Echo to UDP Client: " + inputLine);
		    if (inputLine.equals("Bye."))
		        break;        
		}
    	serverSocket.close(); 
    } 

	}
	}
	


	
