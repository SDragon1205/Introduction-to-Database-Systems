#include "index.h"

int main(){
	int num_rows = 7;
	vector<int> key = {60, 10, 30, 20, 0, 40, 50};
	vector<int> value = {6, 1, 3, 2, 0, 4, 5};
	vector<int> query_keys = {0, 10, 20, 30, 40, 50, 60, 70};
	vector<pair<int,int>> query_pairs;
	Index myIndex(num_rows, key, value);
	myIndex.key_query(query_keys);
	query_pairs.push_back(make_pair(0,60));
	query_pairs.push_back(make_pair(30,60));
	query_pairs.push_back(make_pair(12,15));
	query_pairs.push_back(make_pair(40,40));
	myIndex.range_query(query_pairs);
	myIndex.clear_index();
	//cout << "range" << myIndex.range(6, 45) << "\n";
	//myIndex.display(myIndex.getRoot());
	
	return 0;
}
