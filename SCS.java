import java.awt.GridLayout;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.Vector;

import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JTextField;

public class SCS extends JFrame {
	private Connection connect = null;
	private Statement statement = null;
	private PreparedStatement preparedStatement = null;
	private ResultSet resultSet = null;
	private int id, pin;

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public int getPin() {
		return pin;
	}

	public void setPin(int pin) {
		this.pin = pin;
	}

	JPanel container, p2, p3;
	Vector<String> tans;
	JButton generate, exit;
	JTextField PIN, Amount, Account, TAN;
	JLabel PINLabel, AmountLabel, AccountLabel, TANLabel;

	SCS() {
		container = new JPanel();
		p2 = new JPanel();
		p3 = new JPanel();
		generate = new JButton("Generate");
		exit = new JButton("Exit");
		PINLabel = new JLabel("PIN: ");
		AmountLabel = new JLabel("Amount: ");
		AccountLabel = new JLabel("To (User id): ");
		TANLabel = new JLabel("TAN: ");
		PIN = new JTextField(6);
		Amount = new JTextField(12);
		Account = new JTextField(12);
		TAN = new JTextField(25);
		p2.setLayout(new GridLayout(4, 1, 5, 5));
		container.setLayout(new GridLayout(3, 2));
		p2.add(PINLabel);
		p2.add(PIN);
		p2.add(AmountLabel);
		p2.add(Amount);
		p2.add(AccountLabel);
		p2.add(Account);
		p2.add(TANLabel);
		p2.add(TAN);
		p3.add(generate);
		p3.add(exit);
		container.add(new JLabel("Please enter the following information:"));
		container.add(p2);
		container.add(p3);
		add(container);
		listen1 handler1 = new listen1();
		generate.addActionListener(handler1);
		listen2 handle2 = new listen2();
		exit.addActionListener(handle2);

	}

	private class listen1 implements ActionListener {

		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub 
			if (!(tans.size() == 0)) {
				if (Integer.parseInt(PIN.getText()) == pin) {
					TAN.setText(tans.remove(0));
					
				} else {
					JOptionPane.showMessageDialog(getParent(), "Wrong PIN!");
				}
			} else {
				TAN.setText("You are out of TANS!");
			}
		}
	}

	private class listen2 implements ActionListener {

		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			System.exit(0);
		}
	}

	// public void setUserID(int userID) {
	// id = userID;
	// }

	public void readDataBase(int id) throws Exception {
		try {
			// This will load the MySQL driver, each DB has its own driver
			Class.forName("com.mysql.jdbc.Driver");
			// Setup the connection with the DB
			connect = DriverManager.getConnection("jdbc:mysql://localhost/securecoding?" + "user=root&password=");

			// Statements allow to issue SQL queries to the database
			statement = connect.createStatement();

			preparedStatement = connect.prepareStatement("select id from securecoding.tans where user_id=?");
			preparedStatement.setInt(1, id);
			resultSet = preparedStatement.executeQuery();
			writeResultSet(resultSet);

		} catch (Exception e) {
			throw e;
		} finally {
			close();
		}

	}

	private void writeResultSet(ResultSet resultSet) throws SQLException {
		// ResultSet is initially before the first data set
		int i = 1;
		tans = new Vector(100);
		while (resultSet.next()) {
			String tan = resultSet.getString("id");
			tans.addElement(tan);
			// System.out.println("TAN#" + i++ + ": " + user);
		}
	}

	private void close() {
		try {
			if (resultSet != null) {
				resultSet.close();
			}

			if (statement != null) {
				statement.close();
			}

			if (connect != null) {
				connect.close();
			}
		} catch (Exception e) {

		}
	}

	public static void main(String[] args) {

		SCS frame = new SCS();
		String userID = args[0];
		String PIN = args[1];

		int id = Integer.parseInt(userID);
		frame.setPin(Integer.parseInt(PIN));
		// frame.setUserID(id);
		try {
			frame.readDataBase(id);
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();

		}
		frame.setTitle("Smart Card Simulator");
		frame.setSize(300, 300);
		frame.setDefaultCloseOperation(frame.EXIT_ON_CLOSE);
		frame.setLocationRelativeTo(null);
		frame.setVisible(true);
	}

}
