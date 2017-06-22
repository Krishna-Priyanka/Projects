import static java.lang.System.*;
import java.util.*;
class ReadWrite
{	static void write(int[][] arr)
	{
		for (int i = 0; i <arr.length; ++i)
		{	if (i % 4 == 0)
			System.out.println(" ----------");
			for (int j = 0; j <arr[i].length; ++j) 
			{
				if (j % 4 == 0) 
				System.out.print("| ");
				System.out.print(arr[i][j] == 0? "0": Integer.toString(arr[i][j]));
				System.out.print(' ');
	    		}
			System.out.println("| ");
		}
		System.out.println(" ----------");
    	}
	static void read(int[][] arr) 
	{	Scanner s=new Scanner(in);
		String opt="no";
		do{		
			out.println("Enter row");
			int row=s.nextInt();
			out.println("Enter Column");
			int column=s.nextInt();
			out.println("Enter value between 1 to 4");
			int value=s.nextInt();
			arr[row][column]=value;
			write(arr);
			out.println("do you wonna continue(yes/no)");
			opt=s.next();
		}while(opt.equals("yes"));
	}
}
class Utils
{
	static boolean setSudoku(int i, int j, int[][] arr) 
	{	if (i == 4) 
		{	i = 0;
			if (++j == 4) 
			return true; 
		}
		if (arr[i][j] != 0)  // to skip already filled cells
		return setSudoku(i+1,j,arr);//1,0
		//in i=1,j=0  we have 0
		//val=1,2,3,4
		for (int val = 1; val <= 4; ++val)
		{	
			if (isItlegal(i,j,val,arr))
			{	arr[i][j] = val;       
				if (setSudoku(i+1,j,arr))  
				return true;
			}
		}
		arr[i][j] = 0; // reset on backtrack
		return false;
	}
	//i=1,j=0, val=4
	static boolean isItlegal(int i, int j, int val, int[][] arr)
	{	
		for (int k = 0; k < 4; ++k)  // row
		if (val == arr[k][j])
		return false;

		for (int k = 0; k < 4; ++k) // col
	  	if (val == arr[i][k])
		return false;
		return true; // no violations, so it's legal
    	}		
}
public class SudokuAssignment
{	public static void main(String[] args) 
	{	int[][] arr = new int[4][4]; // default 0 vals
		ReadWrite.write(arr);
		ReadWrite.read(arr);
		if (Utils.setSudoku(0,0,arr))    // solves in place
	  	  ReadWrite.write(arr);
		else 
		    System.out.println("NONE");
	}
}