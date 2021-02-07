#include<stdio.h>
#include<string.h>
#include<stdlib.h>
#include<unistd.h>
#include<sys/types.h>
#include<sys/socket.h>
#include<netinet/in.h>
#include<time.h>
void error(const char *msg){
    perror(msg);
    exit(1);
}
int main(int argc ,char *argv[]){
    if(argc<2){
        fprintf(stderr  , "port No. not provided.program terminated\n");
        exit(1);
    }
    int sockfd , newsockfd , portno , n;
    char buffer[255];
    struct sockaddr_in serv_addr, cli_addr;
    socklen_t clilen;

    sockfd = socket(AF_INET , SOCK_STREAM ,0);
    if(sockfd<0){
        error("error opening socket");
    }
    bzero((char *)&serv_addr , sizeof(serv_addr));
    portno = atoi(argv[1]);
    serv_addr.sin_family =AF_INET;
    serv_addr.sin_addr.s_addr = INADDR_ANY;
    serv_addr.sin_port = htons(portno);
    if(bind(sockfd,(struct sockaddr *) &serv_addr , sizeof(serv_addr))<0)
            error("binding failed.");
    listen(sockfd,5);
    clilen = sizeof(cli_addr);

    newsockfd = accept(sockfd , (struct sockaddr *)&cli_addr ,&clilen);
    if(newsockfd < 0)
    error("Error on Accept");
	bzero(buffer,255);
 	 FILE *fp; 
     char choice[255];
     char apl[255];
     char gender[255];
     char cat[255];
     char name[255];
     char txt[] =".txt";
     char uname[255];
     int count=0;
     char district[255];
     char temp[255];
     int line_num = 1;
     int find_result = 0;
    char c;
     int addpatient(){
     	fp = fopen("patientfile.txt","a");
     	
        printf("success\n");
     	printf("Adding patient...\n");
     	}
     	
     	int addpatientlist(){
     	time_t t = time(NULL);
  	struct tm tm = *localtime(&t);
     	fprintf(fp,"%s ",name);
     	fprintf(fp,"%04d-%02d-%02d ",tm.tm_year+1900,tm.tm_mon+1,tm.tm_mday );
     	fprintf(fp,"%s ",gender);
     	fprintf(fp,"%s ",cat);
     	fprintf(fp,"%s \n",uname);
     	printf("patient added!\n");
     	fclose(fp);
     	}
     	int filetransfer(){
     	   FILE *fp;
     	   int words=0;
            	fp = fopen("patientfile.txt","a");
            	if(fp==NULL){
        printf("could not open file ");
        return 0;
    }
            	read(newsockfd, &words, sizeof(int));            
        	read(newsockfd , buffer , 512);
		fwrite(buffer,sizeof(char),words,fp);
		printf("%s",buffer);
     	printf("The file was received successfully\n");
     	fclose(fp);
     	}
     	int checkstatus(){
     	//open the file
    fp=fopen("patientfile.txt","r");
    //check if file exists
    if(fp==NULL){
        printf("could not open file ");
        return 0;
    }
    //extract characters from file and store in character c
    for(c=getc(fp);c!=EOF; c=getc(fp)){
        if(c=='\n'){ // increment if the character is newline
        count++;}}
    write(newsockfd,&count,255);    
    //close the file
   
    printf("the file has %d cases \n", count);
      fclose(fp);
     	}
     	int search(){
     	
     	if((fp = fopen("patientfile.txt", "r")) == NULL) {
	printf("Error opening the file");
		return(-1);
	}

	while(fgets(temp, 255, fp) != NULL) {
		if((strstr(temp, name)) != NULL) {
			find_result++;
	}
	     	
		line_num++;
		
	}
	printf("%d matches\n",find_result);
	write(newsockfd,&find_result,255);
	
	rewind(fp);
	
	int line_num = 1;
	while(fgets(temp, 255, fp) != NULL) {
		if((strstr(temp, name)) != NULL) {
			printf("A match found on line: %d\n", line_num);
			printf("\n%s\n", temp);
			write(newsockfd,temp,255);
			find_result++;
	}
	     	
		line_num++;
		
	}
	if(find_result == 0) {
		printf("\nSorry, couldn't find a match.\n");
	}
	//Close the file if still open.
	if(fp) {
		fclose(fp);
	}
	
	}
     	
    read(newsockfd,uname,255);
    printf("welcome %s!!\n",uname);
    read(newsockfd,district,255);
    printf("your district is %s.\n ",district); 	
    q:
    read(newsockfd, choice, 255);
    printf("choice is  %s\n",choice);
    if(strcmp(choice,"exit")==0){
	goto e;}
    else if(strcmp(choice,"Check_status")==0){
     	checkstatus();
     	puts("bye");
     	goto e;
     	}
    else if(strcmp(choice,"search")==0){
     	read(newsockfd,name,255);
     	search();
     	goto q;
     	}
    else if(strcmp(choice,"addpatient")==0){	
    read(newsockfd , name , 255);
     printf("name is %s\n",name);   
     	if (strstr(name,txt)){
     		printf("its a file\n");
     		filetransfer();
		printf("success\n");
		goto q;
     		}
     		
     	else	{
     		printf("selected\n");
     		addpatient();
     		 read(newsockfd,gender,255);
     		 printf("gender is %s\n",gender);
    		 read(newsockfd,cat,255);
    		 printf("category is %s\n",cat);
     		 read(newsockfd,apl,255);
       		if(strcmp(apl,"addpatientlist")==0){
     			printf("Adding patient 1...\n");
     			addpatientlist();
     			goto q;
     			}
     	}	
     	}	
     		
	else{
	printf("command not found!!\n");
	goto q;
	}
e:
close(newsockfd);
    close(sockfd);
    return 0 ;

}
