import static java.lang.System.*;
import java.util.*;
class ReverseBinary
{	
	static long convert(long value)
	{return Long.parseLong(new StringBuffer(Long.toBinaryString(value)).reverse().toString(),2);
	}
	public static void main(String args[])
	{	Scanner s=new Scanner(in);
		out.println("Enter a value to find binary value");
		out.println(convert(s.nextLong()));	
	}
}