import java.awt.GridLayout;
import java.awt.Toolkit;
import java.awt.datatransfer.StringSelection;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.PrintWriter;
import java.security.DigestInputStream;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.regex.Pattern;

import javax.swing.JButton;
import javax.swing.JFileChooser;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JTextField;

public class SCS extends JFrame {

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	String pin = null;
	String secretKey = null;
	int round = -1;

	JPanel container, p2, p3;
	JButton generate, generateFileButton, selectFileButton;
	JTextField pinField, amountField, accountField;
	JLabel pinLabel, amountLabel, accountLabel, fileLabel;
	File currentFile = null;

	SCS() {
		container = new JPanel();
		p2 = new JPanel();
		p3 = new JPanel();
		generate = new JButton("Generate");
		generateFileButton = new JButton("Generate for file");
		pinLabel = new JLabel("PIN: ");
		amountLabel = new JLabel("Amount: ");
		accountLabel = new JLabel("To (User id): ");
		fileLabel = new JLabel("TAN: ");
		pinField = new JTextField(6);
		amountField = new JTextField(12);
		accountField = new JTextField(12);
		selectFileButton = new JButton("Select File");
		p2.setLayout(new GridLayout(4, 1, 5, 5));
		container.setLayout(new GridLayout(3, 2));
		p2.add(pinLabel);
		p2.add(pinField);
		p2.add(amountLabel);
		p2.add(amountField);
		p2.add(accountLabel);
		p2.add(accountField);
		p2.add(fileLabel);
		p2.add(selectFileButton);
		p3.add(generate);
		p3.add(generateFileButton);
		container.add(new JLabel("Please enter the following information:"));
		container.add(p2);
		container.add(p3);
		add(container);
		generate.addActionListener(new ActionListener() {

			@Override
			public void actionPerformed(ActionEvent e) {
				// check Pin
				String toHash = "";
				if (!pin.equals(pinField.getText())) {
					JOptionPane.showMessageDialog(getParent(), "Wrong PIN!");
					return;
				}

				if (!Pattern.matches("[0-9]*\\.?[0-9]{0,2}", amountField.getText())) {
					JOptionPane.showMessageDialog(getParent(),
							"Only numbers allowed as amount!\nFormat: [0-9]*\\.?[0-9]{0,2}");
				} else {
					toHash = amountField.getText();
				}

				if (accountField.getText().length() != 10 || !Pattern.matches("[0-9]{10}", accountField.getText())) {
					JOptionPane.showMessageDialog(getParent(), "Non valid account number!");
					toHash = "";
				} else {
					toHash += accountField.getText();
				}
				if (toHash.length() == 0 ) {
					return;
				}
				
				Toolkit.getDefaultToolkit().getSystemClipboard().setContents(
                        new StringSelection(sha256ForMessage(secretKey, toHash)), null);
				JOptionPane.showMessageDialog(getParent(), "TAN has been copied to your clipboard");
				updateProps();
			}
		});
		generateFileButton.addActionListener(new ActionListener() {
			
			@Override
			public void actionPerformed(ActionEvent e) {
				if (currentFile == null) {
					JOptionPane.showMessageDialog(getParent(), "No File selected");
					return;
				}
				try {
					FileInputStream fis = new FileInputStream(currentFile);
					Toolkit.getDefaultToolkit().getSystemClipboard().setContents(
	                        new StringSelection(sha256ForFile(secretKey, fis)), null);
					JOptionPane.showMessageDialog(getParent(), "TAN has been copied to your clipboard");
					
					fis.close();
					updateProps();
				} catch (FileNotFoundException e1) {
					JOptionPane.showMessageDialog(getParent(), "Error opening file!");
					e1.printStackTrace();
				} catch (IOException e1) {
					JOptionPane.showMessageDialog(getParent(), "Error reading file!");
					e1.printStackTrace();
				}
			}
		});
		selectFileButton.addActionListener(new ActionListener() {

			@Override
			public void actionPerformed(ActionEvent e) {
				JFileChooser chooser = new JFileChooser();
				int retValue = chooser.showDialog(null, "Select Batch File");
				if (retValue == JFileChooser.APPROVE_OPTION) {
					SCS.this.currentFile = chooser.getSelectedFile();
				}
			}
		});
	}

	/**
	 * 
	 */
	protected void updateProps() {
		try {
			PrintWriter writer = 
			           new PrintWriter(
			                 new File(this.getClass().getResource("/props.txt").getPath()));
			this.round++;
			this.secretKey = sha256(this.secretKey);
			writer.write(pin + "\n" + this.secretKey + "\n" + this.round);
			writer.flush();
			writer.close();
		} catch (FileNotFoundException e) {
			e.printStackTrace();
		}
	}

	public String sha256ForMessage(String secretKey, String msg) {
		MessageDigest md = null;
		try {
			md = MessageDigest.getInstance("SHA-256");
		} catch (NoSuchAlgorithmException e) {
			e.printStackTrace();
		}
		md.update(msg.getBytes());
		md.update(secretKey.getBytes());
		byte[] data = md.digest();
		StringBuffer hexString = new StringBuffer();
		for (int i = 0; i < data.length; i++) {
			hexString.append(Integer.toString((data[i] & 0xff) + 0x100, 16).substring(1));
		}
		return this.round + ";" + hexString.toString();
	}
	
	public String sha256ForFile(String secretKey, InputStream fis) throws IOException {
		MessageDigest md = null;
		try {
			md = MessageDigest.getInstance("SHA-256");
		} catch (NoSuchAlgorithmException e) {
			e.printStackTrace();
		}
		byte[] data = new byte[1024];
		DigestInputStream dis = new DigestInputStream(fis, md);
        while (dis.read(data) != -1) {}
        dis.close();
		md.update(secretKey.getBytes());
		byte[] hashData = md.digest();
		StringBuffer hexString = new StringBuffer();
		for (int i = 0; i < hashData.length; i++) {
			hexString.append(Integer.toString((hashData[i] & 0xff) + 0x100, 16).substring(1));
		}
		return this.round + ";" + hexString.toString();
	}
	
	public String sha256(String message) {
		MessageDigest md = null;
		try {
			md = MessageDigest.getInstance("SHA-256");
		} catch (NoSuchAlgorithmException e) {
			e.printStackTrace();
		}
		md.update(message.getBytes());
		byte[] data = md.digest();
		StringBuffer hexString = new StringBuffer();
		for (int i = 0; i < data.length; i++) {
			hexString.append(Integer.toString((data[i] & 0xff) + 0x100, 16).substring(1));
		}
		return hexString.toString();
	}

	public void showError(String msg) {
		JOptionPane.showMessageDialog(this, msg);
	}

	public static void main(String[] args) {

		SCS frame = new SCS();

		frame.setTitle("Smart Card Simulator");
		frame.setSize(300, 300);
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		frame.setLocationRelativeTo(null);
		frame.setVisible(true);
		
		BufferedReader reader = new BufferedReader(new InputStreamReader(SCS.class.getResourceAsStream("/props.txt")));
		try {
			frame.pin = reader.readLine();
			frame.secretKey = reader.readLine();
			frame.round = Integer.parseInt(reader.readLine());
			reader.close();
		} catch (IllegalArgumentException e) {
			frame.showError("Could not read properties please contact an admin!");
		} catch (IOException e1) {
			frame.showError("Could not read properties please contact an admin!");
		}
	}

}
